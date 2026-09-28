<?php

namespace App\Support;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Throwable;

/**
 * Exception details for the admin view of the 500 page: the exception chain with
 * code around each app frame, and the request with passwords, tokens and cookies hidden.
 */
class ErrorDiagnostics
{
    /** Input fields and headers whose values are never shown. */
    const SECRET = '/pass|token|secret|key|auth|cookie|session|csrf|card|cvv|cvc|iban/i';

    const REDACTED = '••••••';

    /** Lines of code shown before and after the line of a frame. */
    const CONTEXT_LINES = 6;

    /**
     * @param Throwable $e
     * @param Request $request
     * @param string $reference
     * @return array
     */
    public static function from(Throwable $e, Request $request, $reference)
    {
        $exceptions = [];
        for ($current = $e, $depth = 0; $current && $depth < 5; $current = $current->getPrevious(), $depth++) {
            $exceptions[] = self::exception($current);
        }

        $diagnostics = [
            'reference' => $reference,
            'time' => now()->toIso8601String(),
            'exceptions' => $exceptions,
            'request' => self::request($request),
            'environment' => [
                'Laravel' => Application::VERSION,
                'PHP' => PHP_VERSION,
                'Environment' => app()->environment(),
                'Locale' => app()->getLocale(),
            ],
        ];
        $diagnostics['report'] = self::report($diagnostics);

        return $diagnostics;
    }

    private static function exception(Throwable $e)
    {
        $frames = [[
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'call' => null,
        ]];
        foreach ($e->getTrace() as $frame) {
            $frames[] = [
                'file' => $frame['file'] ?? null,
                'line' => $frame['line'] ?? null,
                'call' => ($frame['class'] ?? '') . ($frame['type'] ?? '') . $frame['function'] . '()',
            ];
        }

        $frames = array_map(function ($frame) {
            $vendor = $frame['file'] === null || Str::contains($frame['file'], DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR);

            return $frame + [
                'path' => $frame['file'] ? self::relative($frame['file']) : '[internal]',
                'vendor' => $vendor,
                'code' => $vendor ? [] : self::code($frame['file'], $frame['line']),
            ];
        }, $frames);

        return [
            'class' => get_class($e),
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'path' => self::relative($e->getFile()),
            'line' => $e->getLine(),
            'frames' => $frames,
        ];
    }

    private static function request(Request $request)
    {
        $route = $request->route();
        $user = $request->user();

        $input = self::redact($request->except(array_keys($request->allFiles())));
        foreach ($request->allFiles() as $name => $files) {
            $input[$name] = collect(is_array($files) ? $files : [$files])->map(function ($file) {
                return $file instanceof UploadedFile ? $file->getClientOriginalName() . ' (' . $file->getSize() . ' B)' : '[file]';
            })->implode(', ');
        }

        $headers = [];
        foreach ($request->headers->all() as $name => $values) {
            $headers[$name] = preg_match(self::SECRET, $name) ? self::REDACTED : implode(', ', $values);
        }

        return [
            'summary' => array_filter([
                'Method' => $request->method(),
                'URL' => self::redactUrl($request->fullUrl()),
                'Route' => $route ? ($route->getName() ?? $route->uri()) : null,
                'Action' => $route ? $route->getActionName() : null,
                'User' => $user ? '#' . $user->id . ' ' . $user->email . ($user->role ? ' (' . $user->role . ')' : '') : __('Guest'),
                'IP' => $request->ip(),
                'User agent' => $request->userAgent(),
                'Referer' => $request->headers->get('referer'),
            ]),
            'input' => $input,
            'headers' => $headers,
            'session' => $request->hasSession() ? array_keys($request->session()->all()) : [],
        ];
    }

    /**
     * Lines around $line, as [number => code].
     */
    private static function code($file, $line)
    {
        if (!$file || !$line || !is_file($file) || !is_readable($file) || !Str::startsWith(realpath($file), base_path())) {
            return [];
        }

        $lines = @file($file, FILE_IGNORE_NEW_LINES);
        if ($lines === false) {
            return [];
        }
        $start = max(1, $line - self::CONTEXT_LINES);
        $end = min(count($lines), $line + self::CONTEXT_LINES);
        $code = [];
        for ($number = $start; $number <= $end; $number++) {
            $code[$number] = $lines[$number - 1];
        }

        return $code;
    }

    private static function redact(array $values)
    {
        foreach ($values as $key => $value) {
            if (preg_match(self::SECRET, (string) $key)) {
                $values[$key] = self::REDACTED;
            } elseif (is_array($value)) {
                $values[$key] = self::redact($value);
            } elseif (is_string($value)) {
                $values[$key] = Str::limit($value, 300);
            }
        }

        return $values;
    }

    private static function redactUrl($url)
    {
        return preg_replace_callback('/([?&])([^=&]+)=([^&]*)/', function ($m) {
            return $m[1] . $m[2] . '=' . (preg_match(self::SECRET, urldecode($m[2])) ? self::REDACTED : $m[3]);
        }, $url);
    }

    private static function relative($file)
    {
        return ltrim(Str::after($file, base_path()), DIRECTORY_SEPARATOR);
    }

    /**
     * Plain-text summary for the "Copy details" button.
     */
    private static function report(array $diagnostics)
    {
        $lines = [$diagnostics['reference'] . '  ' . $diagnostics['time']];
        foreach ($diagnostics['request']['summary'] as $name => $value) {
            if (in_array($name, ['Method', 'URL', 'Route', 'User'], true)) {
                $lines[] = $name . ': ' . $value;
            }
        }
        foreach ($diagnostics['exceptions'] as $i => $exception) {
            $lines[] = '';
            $lines[] = ($i > 0 ? 'Caused by: ' : '') . $exception['class'] . ': ' . $exception['message'];
            $lines[] = '  at ' . $exception['path'] . ':' . $exception['line'];
            foreach (array_slice($exception['frames'], 1, 15) as $frame) {
                $lines[] = '  ' . ($frame['call'] ?? '') . ' ' . $frame['path'] . ($frame['line'] ? ':' . $frame['line'] : '');
            }
        }
        $lines[] = '';
        $lines[] = collect($diagnostics['environment'])->map(function ($value, $name) {
            return "$name $value";
        })->implode(', ');

        return implode("\n", $lines);
    }
}
