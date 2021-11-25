<?php

namespace Database\Seeders;

use App\Models\Smartphone;
use Illuminate\Database\Seeder;

class SmartphoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $smartphone = new Smartphone([
            'name' => 'Samsung Galaxy A52 6GB/128GB',
            'price' => 189.99,
            'quantity' => 10,
            'brand_id' => 1,
            'color_id' => 1,
            'description' => 'Elegantný smartfón s veľkým displejom, ktorý chráni oči a zobrazuje všetko plynulo a čitateľne, nech už sú okolité podmienky akékoľvek. Štyri objektívy fotoaparátu vytvoria ultraširokouhlé snímky, stabilný a jasný obraz, rozostrené pozadie aj makro fotografie. Stabilné sú aj videá a selfie portréty vo vysokom rozlíšení. Telefón je vodoodolný, takže si s ním môžete ísť pokojne zaplávať. Veľkokapacitná batéria vydrží celý víkend a rýchlonabíjanie sa postará o dodanie energie bez zbytočného zdržiavania. K lepšiemu zážitku z hrania hier prispeje Game Booster a dva špičkové reproduktory. Vďaka Samsung Knox a snímaču odtlačkov prstov je Galaxy A52 zabezpečený na jednotku.',
            'ram' => 6144,
            'operating_system' => 'Android',
            'os_version' => 11,
            'display_size' => 6.5,
            'resolution' => '2400 x 1080',
            'height' => 159.9,
            'width' => 75.1,
            'thickness' => 8.4,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Xiaomi Redmi Note 10 Pro 6GB/128GB',
            'price' => 299.00,
            'quantity' => 20,
            'brand_id' => 3,
            'color_id' => 2,
            'description' => 'Špičkovo vybavený fotoaparát zaujme každého, kto si rád uchováva spomienky vo forme snímok a videí. S ohromnou ponukou funkcií a režimov vás práca fotografa bude baviť omnoho viac. Vytvorte neobyčajné snímky, na ktorých budete hneď niekoľkokrát, alebo nakombinujte obrazy z prednej a zadnej kamery do jedného. Vďaka dlhej výdrži batérie môžete vyraziť na výlet aj bez nabíjačky a s výkonným procesorom vás nebude pri práci nič zdržiavať. Trojrozmerný zvuk znamená viac zábavy pri pozeraní filmov aj hraní hier. To všetko v inteligentnom telefóne s nadčasovým dizajnom.',
            'ram' => 6144,
            'operating_system' => 'Android',
            'os_version' => 11,
            'display_size' => 6.67,
            'resolution' => '2400 x 1080',
            'height' => 164,
            'width' => 76.5,
            'thickness' => 8.1,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Apple iPhone 12 128GB',
            'price' => 818.90,
            'quantity' => 30,
            'brand_id' => 7,
            'color_id' => 3,
            'description' => 'Dvanásta generácia obľúbeného smartfónu vás svojou výbavou určite nesklame. Výkonný procesor zvládne aj náročné operácie v priebehu okamihu a navyše je energeticky nenáročný. Prakticky bezrámčekový displej hrá všetkými farbami a jednotlivé pixely majú samostatné podsvietenie, takže si všetok obsah vychutnáte v ešte lepšom podaní. Zariadenie podporuje mobilné siete 5G, vďaka čomu môžete sťahovať, telefonovať aj sledovať online prenosy v skvelej kvalite. Dvojitý fotoaparát disponuje množstvom funkcií a efektov, s ktorými každú snímku aj video dotiahnete k dokonalosti. A navyše je iPhone 12 odolný proti prachu, vode aj nárazu.',
            'ram' => 4096,
            'operating_system' => 'iOS',
            'os_version' => 14,
            'display_size' => 6.1,
            'resolution' => '2532 x 1170',
            'height' => 146.7,
            'width' => 71.5,
            'thickness' => 7.4,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Apple iPhone 11 64GB',
            'price' => 638.00,
            'quantity' => 50,
            'brand_id' => 7,
            'color_id' => 4,
            'description' => 'Hlavným lákadlom, na ktorý sa spoločnosť Apple najviac zamerala, je dlho očakávaná fotosústava so širokouhlým a ultraširokouhlým záberom, ktorá vám dovolí zachytiť scénu v celej svojej kráse a navyše poskytne až dvojnásobný optický zoom. Okrem toho ponúkne úchvatný nočný režim, s ktorým môžete fotiť aj v hlbokej tme. Pozadu nezostalo ani video s rozlíšením 4K pri 60 snímkach za sekundu či spomalený režim s až 240 snímkami vo Full HD. Toto všetko bez zaváhania spracuje nový procesor A13 Bionic s ultrarýchlou grafickou jednotkou, ktorá si poradí s akokoľvek náročnou hrou či aplikáciou. Telo sa chváli najodolnejším sklom na trhu a obsahuje batériu, ktorá vydrží až 17 hodín prehrávať video a rýchlo sa nabije.',
            'ram' => 4096,
            'operating_system' => 'iOS',
            'os_version' => 13,
            'display_size' => 6.1,
            'resolution' => '1792 x 828',
            'height' => 150.9,
            'width' => 75.7,
            'thickness' => 8.3,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Samsung Galaxy S20 6GB/128GB Dual SIM',
            'price' => 468.00,
            'quantity' => 100,
            'brand_id' => 1,
            'color_id' => 5,
            'description' => 'Inteligentnému telefónu od spoločnosti Samsung nič nechýba. Trojitý fotoaparát ponúka množstvo rôznych funkcií a režimov, vďaka ktorým budú vaše snímky kvalitnejšie ako kedykoľvek predtým. Predný objektív s vysokým rozlíšením sa postará o ostré a realistické selfie fotky. Výkonný procesor, 6 GB pamäť RAM a podpora LTE a Wi-Fi 6 zaistia bezchybný a plynulý chod telefónu a veľké vnútorné úložisko s podporou pamäťovej karty pojme viac aplikácií, hier, filmov a pesničiek, ako budete potrebovať. Galaxy S20 FE je navyše vodoodolný, kompatibilný s ďalšími zariadeniami a vyrába sa v niekoľkých farebných prevedeniach, takže si vyberie aj ten najnáročnejší používateľ.',
            'ram' => 6144,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 6.5,
            'resolution' => '2400 x 1080',
            'height' => 159.8,
            'width' => 74.5,
            'thickness' => 8.4,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Samsung Galaxy S21 5G 8GB/128GB',
            'price' => 705.90,
            'quantity' => 200,
            'brand_id' => 1,
            'color_id' => 6,
            'description' => 'Vodoodolný telefón od Samsungu je prepracovaný zo všetkých strán. Má veľký displej s plynulým obrazom a ochranou pre oči a navyše je obrazovka chránená odolným sklom Corning Gorilla. Nakrúca 8K stabilné a superplynulé videá, z ktorých potom vytvorí aj fotografie. Dokáže fotiť aj v tme tak, aby boli výsledné snímky perfektne viditeľné. Batéria sa nabije v priebehu chvíľky a o energiu sa dokáže podeliť aj s inými zariadeniami. Okrem toho je smartfón zabezpečený ochranou Knox, vie pracovať s 5G a pripojí sa k televízoru aj počítaču.',
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 11,
            'display_size' => 6.2,
            'resolution' => '2400 x 1080',
            'height' => 151.7,
            'width' => 71.2,
            'thickness' => 7.9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Samsung Galaxy A12 4GB/64GB',
            'price' => 178.90,
            'quantity' => 150,
            'brand_id' => 1,
            'color_id' => 7,
            'description' => 'Inteligentný mobilný telefón Samsung Galaxy A12 v sebe kombinuje nadupané vybavenie s elegantným moderným dizajnom. Poteší vás osemjadrovým procesorom, štvornásobným fotoaparátom so 48 Mpix i veľkokapacitnou batériou. Všetok obsah si pozriete na špičkovom Infinity-V displeji so 6,5-palcovou uhlopriečkou a HD+ rozlíšením. Smartfón je vybavený Androidom s množstvom inteligentných funkcií a viacvrstvovým zabezpečením. Dizajn telefónu vám padne do oka vďaka krásnym farbám i nadčasovému spracovaniu.',
            'ram' => 4096,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 6.5,
            'resolution' => '1600 x 720',
            'height' => 164.0,
            'width' => 75.8,
            'thickness' => 8.9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Xiaomi Redmi 9A 2GB/32GB',
            'price' => 109.99,
            'quantity' => 100,
            'brand_id' => 3,
            'color_id' => 8,
            'description' => 'Jednoduchý dizajn so zadnou stranou, ktorá odolá odtlačkom prstov, sa nestratí na večierku ani na pracovnom stretnutí. Takmer bezrámčekový displej s kvapkovitým výrezom vyžaruje menej modrého svetla, a preto vás ani pri dlhodobej práci na telefóne nebudú bolieť oči. Veľkokapacitná batéria vám umožní používať smartfón počas celého dňa bez nutnosti nabitia a vďaka dlhšej životnosti si jej kvality môžete užívať ešte dlhšie, ako by ste čakali. S výkonným procesorom, zamykaním obrazovky pomocou tváre a fotoaparátom s umelou inteligenciou bude používanie telefónu ešte zábavnejšie a bezpečnejšie.',
            'ram' => 2048,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 6.53,
            'resolution' => '1600 x 720',
            'height' => 164.9,
            'width' => 77.07,
            'thickness' => 9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Xiaomi Redmi Note 9 Pro 6GB/128GB',
            'price' => 239.00,
            'quantity' => 90,
            'brand_id' => 3,
            'color_id' => 9,
            'description' => 'Štyri rôzne objektívy fotoaparátu zvečnia akýkoľvek moment ako živý a so selfie kamerou sa vám podarí zachytiť svoje portréty aj v slow-motion verzii. Natáčanie videí bude ešte jednoduchšie vďaka množstvu rôznych filtrov, režimov a módov, s ktorými jednoducho vytvoríte vlogy aj krátke filmy. V telefóne je pripravená aj aplikácia na skenovanie a úpravu dokumentov, ktorú využijete pri práci. Dlhá výdrž batérie spolu s výkonným procesorom zvládnu aj tie najnáročnejšie požiadavky a poradia si s akýmkoľvek programom alebo hrou. Všetko budete mať zabezpečené odtlačkom prsta.',
            'ram' => 6144,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 6.67,
            'resolution' => '2340 x 1080',
            'height' => 165.75,
            'width' => 76.68,
            'thickness' => 8.8,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Huawei P30 Lite 4GB/128GB Dual SIM',
            'price' => 209.90,
            'quantity' => 25,
            'brand_id' => 2,
            'color_id' => 1,
            'description' => 'Prepracovaný telefón s veľkým displejom a elegantným designom, vďaka ktorému sa i kvôli veľkým rozmerom obrazovky ľahko ovláda jednou rukou. Naviac je rýchly a má veľký výkon, ktorý vám bude stačiť i pri náročnom hraní hier, takže sa nemusíte obávať nepríjemného sekania a pomalého načítania. Veľká užívateľská pamäť, rýchle nabíjanie a perfektné spracovanie grafiky vám prácu s telefónom ešte viac spríjemnia. Okrem toho na vás čaká fotoaparát, ktorý sa postará o snímky kvalitou porovnateľné s hociktorými profesionálnymi príjstrojmi. A, samozrejme, plno ďalších vylepšení, ktoré vám uľahčia prácu.',
            'ram' => 4096,
            'operating_system' => 'Android',
            'os_version' => 9,
            'display_size' => 6.15,
            'resolution' => '2312 x 1080',
            'height' => 152.9,
            'width' => 72.7,
            'thickness' => 7.4,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Huawei P Smart 2021 Dual SIM',
            'price' => 199.99,
            'quantity' => 17,
            'brand_id' => 2,
            'color_id' => 2,
            'description' => 'Inteligentný telefón od Huawei vás naláka už svojim kvalitným spracovaním a modernými farbami. Elegantný vzhľad podtrhne veľký displej s vysokým rozlíšením alebo čítačka odtlačkov prstov, ktorú nájdete na bočnej strane prístroja. Nechýba ani veľká používateľská pamäť a úsporná batéria s rýchlym nabíjaním. Štvornásobný fotoaparát je pripravený na všetko, s čím by ste sa mohli stretnúť. Disponuje ultraširokouhlým objektívom, makro objektívom, hĺbkovým objektívom a hlavnou kamerou s vysokým rozlíšením.',
            'ram' => 4096,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 6.67,
            'resolution' => '1400 x 1080',
            'height' => 165.65,
            'width' => 76.88,
            'thickness' => 9.26,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Huawei P40 Lite 6GB/128GB Dual SIM',
            'price' => 219.99,
            'quantity' => 19,
            'brand_id' => 2,
            'color_id' => 3,
            'description' => 'Chytrý telefón Huawei P40 Lite poteší každého milovníka mobilných technológií. V jeho vybavení objavíte pokročilý štvornásobný fotoaparát, nadupaný výkon i inteligentné prostredie. Urobíte s ním parádne snímky vo dne aj v noci a tešiť sa môžete aj na plynulý chod a dostatočnú pamäť. Vydarený dizajn svojím decentným spracovaním doplní akýkoľvek štýl. Vďaka vysokokapacitnej batérii vám telefón vydrží v prevádzke aj po dlhý deň a pomocou technológie rýchleho nabíjania mu dodáte stratenú energiu prekvapivo rýchlo.',
            'ram' => 6144,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 6.4,
            'resolution' => '2310 x 1080',
            'height' => 159.2,
            'width' => 76.3,
            'thickness' => 8.7,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Lenovo K10 Note 6/128',
            'price' => 199.00,
            'quantity' => 45,
            'brand_id' => 4,
            'color_id' => 4,
            'description' => 'Mobilný telefón Lenovo K10 Note vás zaujme elegantným telom bez rámikov, ktorému dominuje veľký displej cez celú prednú plochu. Srdcom telefónu je výkonný 8-jadrový procesor so 6 GB pamäťou RAM na rýchlu odozvu systému Android 9 a všetkých aplikácií a hier. Na ukladanie dát je k dispozícii veľká vnútorná pamäť s kapacitou 128 GB s možnosťou jej rozšírenia pomocou pamäťovej karty do veľkosti až 256 GB. Na zabezpečenie telefónu sa na zadnej strane nachádza čítačka odtlačkov prstov.',
            'ram' => 6144,
            'operating_system' => 'Android',
            'os_version' => 9,
            'display_size' => 6.3,
            'resolution' => '2340 x 1080',
            'height' => 156.6,
            'width' => 74.3,
            'thickness' => 7.9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Nokia G10',
            'price' => 129.90,
            'quantity' => 22,
            'brand_id' => 5,
            'color_id' => 5,
            'description' => 'Nokia G10 disponuje rafinovaným škandinávskym dizajnom inšpirovaným severskými farbami a zaujme všetkých, ktorí ocenia praktickú eleganciu v kombinácii s najmodernejšou technológiou. Telefón ponúka kvalitný zadný fotoaparát s rozlíšením 13 + 2 + 2 Mpx, fotovýbavy okrem hlavného objektívu ponúkne makro aj hĺbkový objektív. Nechýba kvalitný portrétny a nočný režim, ktoré zaistia farebné a ostré fotografie aj za horších svetelných podmienok. Kvalitné selfie zaistí 8 Mpx predná kamera. Fotografie si v plnej farebnosti vychutnáte na dotykovom IPS LCD displeji s HD+ rozlíšením 1600×720 px a veľkosťou 6,52 palcov, ktorá poskytne dokonalý zážitok pri sledovaní videí, hraní hier alebo surfovaní na internete!',
            'ram' => 3072,
            'operating_system' => 'Android',
            'os_version' => 11,
            'display_size' => 6.5,
            'resolution' => '1600 x 720',
            'height' => 164.9,
            'width' => 76.0,
            'thickness' => 9.2,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Nokia 8000 Dual Sim',
            'price' => 75.90,
            'quantity' => 310,
            'brand_id' => 5,
            'color_id' => 6,
            'description' => 'Držte krok s modernými technológiami. Nokia 8000 4G podporuje rýchle mobilné siete LTE, zostanete tak vždy v spojení s okolitým svetom! Vďaka sociálnym a komunikačným platformám Whatsapp a Facebook sa ľahko spojíte s vašimi priateľmi, môžete tiež streemovať videá na YouTube alebo pomocou Google Map plánovať cestovateľské dobrodružstvo. Funkcia Asistenta Google zabezpečí potrebné informácie stlačením jedného tlačidla, poteší aj WiFi, Bluetooth a polohový senzor A-GPS! Pre počúvanie hudby je telefón vybavený 3,5 mm slúchadlovým konektorom, nechýba ani microUSB port. Interné úložisko možno navyše rozšíriť až o 32GB vďaka integrovanému slotu na pamäťovú kartu a telefón sa pýši aj Dual SIM!',
            'ram' => 512,
            'operating_system' => 'Android',
            'os_version' => 9,
            'display_size' => 2.8,
            'resolution' => '320 x 240',
            'height' => 132.2,
            'width' => 56.5,
            'thickness' => 12.3,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Sony Xperia 10 6GB/128GB Dual SIM',
            'price' => 403.09,
            'quantity' => 40,
            'brand_id' => 6,
            'color_id' => 7,
            'description' => 'Moderný design, vysoký výkon, rýchlosť 5G, spoľahlivá batéria, rýchle nabíjanie, vodoodolné telo. To je iba niekoľko výhod modelu Sony Xperia 10 III. Ponúka tiež tri objektívy - širokouhlý, všestranný a teleobjektív, takže sa stanete autorom dych vyrážajúcich expresívnych portrétov, momentiek či záberov rôznorodej krajiny plných detailov. Automatický režim navyše ponúka funkciu rozoznávania zvierat, upraví expozíciu a dohliadne na to, aby bola fotografia maximálne ostrá. Podarí sa vám zachytiť menu v reštaurácii, podvečernú kompozíciu pri minimálnom osvetlení, detail tváre v protisvetle či pohyb. Telefón vyhotoví aj kvalitné videozáznamy v 4K rozlíšení (štvornásobok Full HD).',
            'ram' => 6000,
            'operating_system' => 'Android',
            'os_version' => 11,
            'display_size' => 6.0,
            'resolution' => '2520 x 1080',
            'height' => 154.0,
            'width' => 68.0,
            'thickness' => 8.3,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Sony Xperia 1 12GB/256GB',
            'price' => 1299.00,
            'quantity' => 3,
            'brand_id' => 6,
            'color_id' => 8,
            'description' => 'Tento smartphone si vás získa unikátnym designom odolným voči vode i prachu a prekvapujúcou výdržou batérie. Jeho najdôležitejšou prednosťou je však fotoaparát so štyrmi objektívmi, ktorý automaticky zaostrí aj na pohybujúce sa objekty. Disponuje tiež sofistikovaným snímačom 3D iToF a množstvom režimov. Technológia CineAlta umožní nakrúcanie filmov s nastavením farieb a parametrov podobným tým, aké používajú profesionálni filmoví tvorcovia. Svoje výtvory si následne prezriete na inovovanom 4K HDR OLED displeji.',
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 11,
            'display_size' => 6.5,
            'resolution' => '1644 x 3840',
            'height' => 165.0,
            'width' => 71.0,
            'thickness' => 8.2,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Sony Xperia 5',
            'price' => 999.00,
            'quantity' => 0,
            'brand_id' => 6,
            'color_id' => 9,
            'description' => 'Smartfón Xperia 5 III je kompaktný, výkonný a kombinuje rýchle AF jeho predchodcu s novou optikou s ohniskovou vzdialenosťou až 105 mm. Či už fotíte alebo hráte hry, padne vám do ruky a prekoná vaše očakávania.',
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 6.1,
            'resolution' => '2520 x 1080',
            'height' => 157.0,
            'width' => 68.0,
            'thickness' => 8.2,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Nokia 150 Single Sim',
            'price' => 34.90,
            'quantity' => 61,
            'brand_id' => 5,
            'color_id' => 1,
            'description' => 'Nokia 150 v sebe snúbi pekný dizajn s praktickosťou. Telo telefónu si zachová vždy svojou farbu vďaka použitému polykarbonátu. Pod prehľadným 2,4" farebným displejom sa nachádzajú prehľadné veľké tlačidlá vďaka ktorým budeme mať vždy istý stisk.',
            'ram' => 512,
            'operating_system' => 'Android',
            'os_version' => 10,
            'display_size' => 2.4,
            'resolution' => '240 x 320',
            'height' => 118.0,
            'width' => 50.0,
            'thickness' => 13.5,
        ]);
        $smartphone->save();
    }
}
