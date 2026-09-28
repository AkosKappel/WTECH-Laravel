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
            'description' => 'An elegant smartphone with a large, eye-friendly display that stays smooth and readable in any conditions. Four camera lenses capture ultra-wide shots, steady and sharp images, blurred backgrounds and macro photos, with stabilised video and high-resolution selfies. The phone is water resistant, so you can even take it for a swim. The large battery lasts all weekend and fast charging tops it up without delay. Game Booster and two quality speakers make gaming more fun, and Samsung Knox with a fingerprint reader keeps the Galaxy A52 secure.',
            'description_translations' => [
                'de' => 'Ein elegantes Smartphone mit großem, augenschonendem Display, das unter allen Bedingungen flüssig und gut lesbar bleibt. Vier Kameraobjektive liefern Ultraweitwinkel-Aufnahmen, scharfe und stabile Bilder, unscharfe Hintergründe und Makrofotos – dazu stabilisierte Videos und hochauflösende Selfies. Das Handy ist wasserdicht, Sie können also sogar damit schwimmen gehen. Der große Akku hält das ganze Wochenende, und das Schnellladen füllt ihn ohne lange Wartezeit wieder auf. Game Booster und zwei hochwertige Lautsprecher machen Spiele noch spannender, und Samsung Knox mit Fingerabdrucksensor schützt das Galaxy A52 zuverlässig.',
                'sk' => 'Elegantný smartfón s veľkým displejom, ktorý chráni oči a zobrazuje všetko plynulo a čitateľne, nech už sú okolité podmienky akékoľvek. Štyri objektívy fotoaparátu vytvoria ultraširokouhlé snímky, stabilný a jasný obraz, rozostrené pozadie aj makro fotografie. Stabilné sú aj videá a selfie portréty vo vysokom rozlíšení. Telefón je vodoodolný, takže si s ním môžete ísť pokojne zaplávať. Veľkokapacitná batéria vydrží celý víkend a rýchlonabíjanie sa postará o dodanie energie bez zbytočného zdržiavania. K lepšiemu zážitku z hrania hier prispeje Game Booster a dva špičkové reproduktory. Vďaka Samsung Knox a snímaču odtlačkov prstov je Galaxy A52 zabezpečený na jednotku.',
            ],
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
            'description' => 'A top-equipped camera for everyone who loves keeping memories in photos and videos. A huge choice of features and modes makes photography more fun: create unusual shots with yourself in them several times, or combine the front and rear cameras in one picture. The long battery life lets you head out without a charger, and the powerful processor keeps up with anything you do. 3D sound means more fun with films and games, all in a smartphone with a timeless design.',
            'description_translations' => [
                'de' => 'Eine erstklassig ausgestattete Kamera für alle, die Erinnerungen gern in Fotos und Videos festhalten. Die große Auswahl an Funktionen und Modi macht das Fotografieren noch unterhaltsamer: Erstellen Sie ungewöhnliche Aufnahmen, auf denen Sie mehrmals zu sehen sind, oder kombinieren Sie Front- und Rückkamera in einem Bild. Dank der langen Akkulaufzeit können Sie auch ohne Ladegerät losziehen, und der leistungsstarke Prozessor hält mit allem mit. 3D-Sound sorgt für mehr Spaß bei Filmen und Spielen – alles in einem Smartphone mit zeitlosem Design.',
                'sk' => 'Špičkovo vybavený fotoaparát zaujme každého, kto si rád uchováva spomienky vo forme snímok a videí. S ohromnou ponukou funkcií a režimov vás práca fotografa bude baviť omnoho viac. Vytvorte neobyčajné snímky, na ktorých budete hneď niekoľkokrát, alebo nakombinujte obrazy z prednej a zadnej kamery do jedného. Vďaka dlhej výdrži batérie môžete vyraziť na výlet aj bez nabíjačky a s výkonným procesorom vás nebude pri práci nič zdržiavať. Trojrozmerný zvuk znamená viac zábavy pri pozeraní filmov aj hraní hier. To všetko v inteligentnom telefóne s nadčasovým dizajnom.',
            ],
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
            'description' => 'The twelfth generation of the popular smartphone will not disappoint. Its powerful processor handles demanding tasks in an instant while staying energy efficient. The almost bezel-less display shows every colour vividly, with individually lit pixels for even better picture quality. 5G support means fast downloads, clear calls and smooth live streams. The dual camera offers plenty of features and effects to perfect every photo and video, and the iPhone 12 is resistant to dust, water and impacts.',
            'description_translations' => [
                'de' => 'Die zwölfte Generation des beliebten Smartphones wird Sie nicht enttäuschen. Der leistungsstarke Prozessor erledigt anspruchsvolle Aufgaben im Handumdrehen und arbeitet dabei energieeffizient. Das nahezu randlose Display zeigt alle Farben lebendig, mit einzeln beleuchteten Pixeln für eine noch bessere Bildqualität. Dank 5G-Unterstützung laden Sie schnell herunter, telefonieren klar und streamen flüssig. Die Dual-Kamera bietet viele Funktionen und Effekte für perfekte Fotos und Videos, und das iPhone 12 ist staub-, wasser- und stoßfest.',
                'sk' => 'Dvanásta generácia obľúbeného smartfónu vás svojou výbavou určite nesklame. Výkonný procesor zvládne aj náročné operácie v priebehu okamihu a navyše je energeticky nenáročný. Prakticky bezrámčekový displej hrá všetkými farbami a jednotlivé pixely majú samostatné podsvietenie, takže si všetok obsah vychutnáte v ešte lepšom podaní. Zariadenie podporuje mobilné siete 5G, vďaka čomu môžete sťahovať, telefonovať aj sledovať online prenosy v skvelej kvalite. Dvojitý fotoaparát disponuje množstvom funkcií a efektov, s ktorými každú snímku aj video dotiahnete k dokonalosti. A navyše je iPhone 12 odolný proti prachu, vode aj nárazu.',
            ],
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
            'description' => 'The highlight is the long-awaited wide and ultra-wide camera system, which captures a scene in all its beauty and offers 2x optical zoom out. Night mode lets you take pictures even in deep darkness, and video goes up to 4K at 60 fps, with slow motion at up to 240 fps in Full HD. All of this is handled by the A13 Bionic chip with an ultra-fast GPU that copes with any game or app. The body features very durable glass and a battery that plays up to 17 hours of video and charges quickly.',
            'description_translations' => [
                'de' => 'Das Highlight ist das lang erwartete Kamerasystem mit Weitwinkel und Ultraweitwinkel, das eine Szene in ihrer ganzen Schönheit einfängt und 2-fach optisch herauszoomt. Mit dem Nachtmodus fotografieren Sie sogar in tiefer Dunkelheit, Videos gelingen in 4K mit 60 Bildern pro Sekunde, Zeitlupe mit bis zu 240 Bildern pro Sekunde in Full HD. All das verarbeitet der A13 Bionic Chip mit ultraschneller Grafikeinheit, der jedes Spiel und jede App meistert. Das Gehäuse besteht aus sehr widerstandsfähigem Glas und enthält einen Akku, der bis zu 17 Stunden Videowiedergabe schafft und schnell lädt.',
                'sk' => 'Hlavným lákadlom, na ktorý sa spoločnosť Apple najviac zamerala, je dlho očakávaná fotosústava so širokouhlým a ultraširokouhlým záberom, ktorá vám dovolí zachytiť scénu v celej svojej kráse a navyše poskytne až dvojnásobný optický zoom. Okrem toho ponúkne úchvatný nočný režim, s ktorým môžete fotiť aj v hlbokej tme. Pozadu nezostalo ani video s rozlíšením 4K pri 60 snímkach za sekundu či spomalený režim s až 240 snímkami vo Full HD. Toto všetko bez zaváhania spracuje nový procesor A13 Bionic s ultrarýchlou grafickou jednotkou, ktorá si poradí s akokoľvek náročnou hrou či aplikáciou. Telo sa chváli najodolnejším sklom na trhu a obsahuje batériu, ktorá vydrží až 17 hodín prehrávať video a rýchlo sa nabije.',
            ],
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
            'description' => 'This Samsung smartphone has everything you need. The triple camera offers many features and modes for better photos than ever, and the high-resolution front camera takes sharp, realistic selfies. A powerful processor, 6 GB of RAM, LTE and Wi-Fi 6 keep everything running smoothly, and the large storage with memory card support holds more apps, games, films and music than you will need. The Galaxy S20 FE is also water resistant, works well with other devices and comes in several colours.',
            'description_translations' => [
                'de' => 'Diesem Samsung-Smartphone fehlt es an nichts. Die Dreifachkamera bietet viele Funktionen und Modi für bessere Fotos als je zuvor, und die hochauflösende Frontkamera macht scharfe, realistische Selfies. Ein leistungsstarker Prozessor, 6 GB RAM, LTE und Wi-Fi 6 sorgen für einen reibungslosen Betrieb, und der große Speicher mit Speicherkartenunterstützung fasst mehr Apps, Spiele, Filme und Musik, als Sie brauchen. Das Galaxy S20 FE ist außerdem wasserdicht, arbeitet gut mit anderen Geräten zusammen und ist in mehreren Farben erhältlich.',
                'sk' => 'Inteligentnému telefónu od spoločnosti Samsung nič nechýba. Trojitý fotoaparát ponúka množstvo rôznych funkcií a režimov, vďaka ktorým budú vaše snímky kvalitnejšie ako kedykoľvek predtým. Predný objektív s vysokým rozlíšením sa postará o ostré a realistické selfie fotky. Výkonný procesor, 6 GB pamäť RAM a podpora LTE a Wi-Fi 6 zaistia bezchybný a plynulý chod telefónu a veľké vnútorné úložisko s podporou pamäťovej karty pojme viac aplikácií, hier, filmov a pesničiek, ako budete potrebovať. Galaxy S20 FE je navyše vodoodolný, kompatibilný s ďalšími zariadeniami a vyrába sa v niekoľkých farebných prevedeniach, takže si vyberie aj ten najnáročnejší používateľ.',
            ],
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
            'description' => 'A water-resistant Samsung phone refined from every angle. It has a large, smooth display with eye protection, covered by tough Corning Gorilla Glass. It records stabilised, ultra-smooth 8K video and can turn frames into photos, and it takes clear pictures even in the dark. The battery charges in no time and can even share power with other devices. On top of that, the phone is protected by Knox, supports 5G and connects to your TV and computer.',
            'description_translations' => [
                'de' => 'Ein wasserdichtes Samsung-Smartphone, das bis ins Detail durchdacht ist. Es hat ein großes, flüssiges Display mit Augenschutz, geschützt durch robustes Corning Gorilla Glass. Es nimmt stabilisierte, besonders flüssige 8K-Videos auf, aus denen Sie sogar Fotos machen können, und fotografiert auch im Dunkeln gut sichtbar. Der Akku ist im Nu geladen und kann seine Energie sogar mit anderen Geräten teilen. Außerdem ist das Smartphone durch Knox geschützt, unterstützt 5G und verbindet sich mit Fernseher und Computer.',
                'sk' => 'Vodoodolný telefón od Samsungu je prepracovaný zo všetkých strán. Má veľký displej s plynulým obrazom a ochranou pre oči a navyše je obrazovka chránená odolným sklom Corning Gorilla. Nakrúca 8K stabilné a superplynulé videá, z ktorých potom vytvorí aj fotografie. Dokáže fotiť aj v tme tak, aby boli výsledné snímky perfektne viditeľné. Batéria sa nabije v priebehu chvíľky a o energiu sa dokáže podeliť aj s inými zariadeniami. Okrem toho je smartfón zabezpečený ochranou Knox, vie pracovať s 5G a pripojí sa k televízoru aj počítaču.',
            ],
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
            'description' => 'The Samsung Galaxy A12 combines generous features with an elegant, modern design. It offers an octa-core processor, a quad camera with a 48 MP main sensor and a high-capacity battery. Everything looks great on the 6.5-inch Infinity-V display with HD+ resolution. The phone runs Android with plenty of smart features and multi-layered security, and its lovely colours and timeless finish catch the eye.',
            'description_translations' => [
                'de' => 'Das Samsung Galaxy A12 verbindet eine großzügige Ausstattung mit elegantem, modernem Design. Es bietet einen Achtkernprozessor, eine Vierfachkamera mit 48 MP und einen Akku mit hoher Kapazität. Alle Inhalte sehen Sie auf dem 6,5-Zoll-Infinity-V-Display in HD+-Auflösung. Das Smartphone läuft mit Android, bietet viele smarte Funktionen und mehrschichtige Sicherheit, und seine schönen Farben und das zeitlose Finish fallen sofort ins Auge.',
                'sk' => 'Inteligentný mobilný telefón Samsung Galaxy A12 v sebe kombinuje nadupané vybavenie s elegantným moderným dizajnom. Poteší vás osemjadrovým procesorom, štvornásobným fotoaparátom so 48 Mpix i veľkokapacitnou batériou. Všetok obsah si pozriete na špičkovom Infinity-V displeji so 6,5-palcovou uhlopriečkou a HD+ rozlíšením. Smartfón je vybavený Androidom s množstvom inteligentných funkcií a viacvrstvovým zabezpečením. Dizajn telefónu vám padne do oka vďaka krásnym farbám i nadčasovému spracovaniu.',
            ],
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
            'description' => 'A simple design with a back that resists fingerprints fits in at a party as well as at a business meeting. The almost bezel-less display with a teardrop notch emits less blue light, so your eyes stay comfortable during long use. The large battery lasts the whole day and is built to last for years. A capable processor, face unlock and an AI camera make the phone more fun and more secure to use.',
            'description_translations' => [
                'de' => 'Ein schlichtes Design mit einer Rückseite, die Fingerabdrücken widersteht, passt zur Party ebenso wie zum Geschäftstermin. Das nahezu randlose Display mit tropfenförmiger Aussparung strahlt weniger blaues Licht ab, damit Ihre Augen auch bei langer Nutzung entspannt bleiben. Der große Akku hält den ganzen Tag und ist auf eine lange Lebensdauer ausgelegt. Ein leistungsfähiger Prozessor, Gesichtsentsperrung und eine KI-Kamera machen die Nutzung noch unterhaltsamer und sicherer.',
                'sk' => 'Jednoduchý dizajn so zadnou stranou, ktorá odolá odtlačkom prstov, sa nestratí na večierku ani na pracovnom stretnutí. Takmer bezrámčekový displej s kvapkovitým výrezom vyžaruje menej modrého svetla, a preto vás ani pri dlhodobej práci na telefóne nebudú bolieť oči. Veľkokapacitná batéria vám umožní používať smartfón počas celého dňa bez nutnosti nabitia a vďaka dlhšej životnosti si jej kvality môžete užívať ešte dlhšie, ako by ste čakali. S výkonným procesorom, zamykaním obrazovky pomocou tváre a fotoaparátom s umelou inteligenciou bude používanie telefónu ešte zábavnejšie a bezpečnejšie.',
            ],
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
            'description' => 'Four camera lenses capture any moment vividly, and the selfie camera can even record portraits in slow motion. Plenty of filters and modes make it easy to create vlogs and short films, and a built-in app scans and edits documents for work. Long battery life and a powerful processor handle the most demanding apps and games, and a fingerprint reader keeps everything secure.',
            'description_translations' => [
                'de' => 'Vier Kameraobjektive halten jeden Moment lebendig fest, und mit der Selfie-Kamera gelingen sogar Porträts in Zeitlupe. Zahlreiche Filter und Modi machen es leicht, Vlogs und Kurzfilme zu erstellen, und eine integrierte App scannt und bearbeitet Dokumente für die Arbeit. Lange Akkulaufzeit und ein starker Prozessor meistern selbst anspruchsvollste Apps und Spiele, und ein Fingerabdrucksensor schützt alles.',
                'sk' => 'Štyri rôzne objektívy fotoaparátu zvečnia akýkoľvek moment ako živý a so selfie kamerou sa vám podarí zachytiť svoje portréty aj v slow-motion verzii. Natáčanie videí bude ešte jednoduchšie vďaka množstvu rôznych filtrov, režimov a módov, s ktorými jednoducho vytvoríte vlogy aj krátke filmy. V telefóne je pripravená aj aplikácia na skenovanie a úpravu dokumentov, ktorú využijete pri práci. Dlhá výdrž batérie spolu s výkonným procesorom zvládnu aj tie najnáročnejšie požiadavky a poradia si s akýmkoľvek programom alebo hrou. Všetko budete mať zabezpečené odtlačkom prsta.',
            ],
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
            'description' => 'A refined phone with a large display and an elegant design that is still easy to use with one hand. It is fast and powerful enough for demanding games, so there is no stuttering or slow loading. Plenty of storage, fast charging and great graphics make it a pleasure to use. The camera takes photos that rival much more expensive devices, and many other improvements make everyday tasks easier.',
            'description_translations' => [
                'de' => 'Ein durchdachtes Smartphone mit großem Display und elegantem Design, das sich trotz der großen Bildschirmfläche gut mit einer Hand bedienen lässt. Es ist schnell und leistungsstark genug für anspruchsvolle Spiele – ohne Ruckeln oder langes Laden. Viel Speicher, Schnellladen und hervorragende Grafik machen die Nutzung zum Vergnügen. Die Kamera liefert Fotos, die mit deutlich teureren Geräten mithalten, und viele weitere Verbesserungen erleichtern den Alltag.',
                'sk' => 'Prepracovaný telefón s veľkým displejom a elegantným designom, vďaka ktorému sa i kvôli veľkým rozmerom obrazovky ľahko ovláda jednou rukou. Naviac je rýchly a má veľký výkon, ktorý vám bude stačiť i pri náročnom hraní hier, takže sa nemusíte obávať nepríjemného sekania a pomalého načítania. Veľká užívateľská pamäť, rýchle nabíjanie a perfektné spracovanie grafiky vám prácu s telefónom ešte viac spríjemnia. Okrem toho na vás čaká fotoaparát, ktorý sa postará o snímky kvalitou porovnateľné s hociktorými profesionálnymi príjstrojmi. A, samozrejme, plno ďalších vylepšení, ktoré vám uľahčia prácu.',
            ],
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
            'description' => 'This Huawei smartphone impresses with quality build and modern colours. The elegant look is completed by a large high-resolution display and a fingerprint reader on the side. It offers plenty of storage and an efficient battery with fast charging. The quad camera is ready for anything, with ultra-wide, macro and depth lenses next to a high-resolution main camera.',
            'description_translations' => [
                'de' => 'Dieses Huawei-Smartphone überzeugt mit hochwertiger Verarbeitung und modernen Farben. Das elegante Erscheinungsbild wird durch ein großes, hochauflösendes Display und einen seitlichen Fingerabdrucksensor abgerundet. Es bietet viel Speicher und einen sparsamen Akku mit Schnellladen. Die Vierfachkamera ist für alles bereit: mit Ultraweitwinkel-, Makro- und Tiefenobjektiv neben einer hochauflösenden Hauptkamera.',
                'sk' => 'Inteligentný telefón od Huawei vás naláka už svojim kvalitným spracovaním a modernými farbami. Elegantný vzhľad podtrhne veľký displej s vysokým rozlíšením alebo čítačka odtlačkov prstov, ktorú nájdete na bočnej strane prístroja. Nechýba ani veľká používateľská pamäť a úsporná batéria s rýchlym nabíjaním. Štvornásobný fotoaparát je pripravený na všetko, s čím by ste sa mohli stretnúť. Disponuje ultraširokouhlým objektívom, makro objektívom, hĺbkovým objektívom a hlavnou kamerou s vysokým rozlíšením.',
            ],
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
            'description' => 'The Huawei P40 Lite will please every fan of mobile technology. It has an advanced quad camera, strong performance and a smart interface, so you get great shots by day and night, smooth operation and enough storage. The understated design suits any style. The high-capacity battery lasts a long day, and fast charging restores the energy surprisingly quickly.',
            'description_translations' => [
                'de' => 'Das Huawei P40 Lite begeistert jeden Fan mobiler Technik. Es bietet eine fortschrittliche Vierfachkamera, starke Leistung und eine intelligente Oberfläche – für tolle Aufnahmen bei Tag und Nacht, flüssigen Betrieb und ausreichend Speicher. Das zurückhaltende Design passt zu jedem Stil. Der Akku mit hoher Kapazität hält einen langen Tag durch, und das Schnellladen füllt ihn überraschend schnell wieder auf.',
                'sk' => 'Chytrý telefón Huawei P40 Lite poteší každého milovníka mobilných technológií. V jeho vybavení objavíte pokročilý štvornásobný fotoaparát, nadupaný výkon i inteligentné prostredie. Urobíte s ním parádne snímky vo dne aj v noci a tešiť sa môžete aj na plynulý chod a dostatočnú pamäť. Vydarený dizajn svojím decentným spracovaním doplní akýkoľvek štýl. Vďaka vysokokapacitnej batérii vám telefón vydrží v prevádzke aj po dlhý deň a pomocou technológie rýchleho nabíjania mu dodáte stratenú energiu prekvapivo rýchlo.',
            ],
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
            'description' => 'The Lenovo K10 Note has an elegant, bezel-less body dominated by a large display across the whole front. At its heart is a powerful octa-core processor with 6 GB of RAM for a responsive Android 9 and all your apps and games. There is 128 GB of storage, expandable with a memory card of up to 256 GB, and a fingerprint reader on the back keeps the phone secure.',
            'description_translations' => [
                'de' => 'Das Lenovo K10 Note beeindruckt mit einem eleganten, randlosen Gehäuse, das von einem großen Display über die gesamte Vorderseite dominiert wird. Herzstück ist ein leistungsstarker Achtkernprozessor mit 6 GB RAM für ein reaktionsschnelles Android 9 und alle Apps und Spiele. Es gibt 128 GB Speicher, erweiterbar per Speicherkarte um bis zu 256 GB, und ein Fingerabdrucksensor auf der Rückseite schützt das Gerät.',
                'sk' => 'Mobilný telefón Lenovo K10 Note vás zaujme elegantným telom bez rámikov, ktorému dominuje veľký displej cez celú prednú plochu. Srdcom telefónu je výkonný 8-jadrový procesor so 6 GB pamäťou RAM na rýchlu odozvu systému Android 9 a všetkých aplikácií a hier. Na ukladanie dát je k dispozícii veľká vnútorná pamäť s kapacitou 128 GB s možnosťou jej rozšírenia pomocou pamäťovej karty do veľkosti až 256 GB. Na zabezpečenie telefónu sa na zadnej strane nachádza čítačka odtlačkov prstov.',
            ],
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
            'description' => 'The Nokia G10 has a refined Scandinavian design inspired by Nordic colours, for everyone who values practical elegance with modern technology. The 13 + 2 + 2 MP rear camera adds macro and depth lenses to the main one, with portrait and night modes for colourful, sharp photos even in poor light, and the 8 MP front camera takes good selfies. Enjoy it all on the 6.52-inch HD+ IPS LCD touchscreen (1600 × 720), which is great for videos, games and browsing.',
            'description_translations' => [
                'de' => 'Das Nokia G10 hat ein raffiniertes skandinavisches Design in nordischen Farben – für alle, die praktische Eleganz mit moderner Technik schätzen. Die Rückkamera mit 13 + 2 + 2 MP ergänzt die Hauptkamera um Makro- und Tiefenobjektiv, Porträt- und Nachtmodus sorgen auch bei wenig Licht für farbenfrohe, scharfe Fotos, und die 8-MP-Frontkamera macht gute Selfies. Genießen Sie alles auf dem 6,52-Zoll-HD+-IPS-LCD-Touchscreen (1600 × 720) – ideal für Videos, Spiele und Surfen.',
                'sk' => 'Nokia G10 disponuje rafinovaným škandinávskym dizajnom inšpirovaným severskými farbami a zaujme všetkých, ktorí ocenia praktickú eleganciu v kombinácii s najmodernejšou technológiou. Telefón ponúka kvalitný zadný fotoaparát s rozlíšením 13 + 2 + 2 Mpx, fotovýbavy okrem hlavného objektívu ponúkne makro aj hĺbkový objektív. Nechýba kvalitný portrétny a nočný režim, ktoré zaistia farebné a ostré fotografie aj za horších svetelných podmienok. Kvalitné selfie zaistí 8 Mpx predná kamera. Fotografie si v plnej farebnosti vychutnáte na dotykovom IPS LCD displeji s HD+ rozlíšením 1600×720 px a veľkosťou 6,52 palcov, ktorá poskytne dokonalý zážitok pri sledovaní videí, hraní hier alebo surfovaní na internete!',
            ],
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
            'description' => 'Keep up with modern technology. The Nokia 8000 4G supports fast LTE networks, so you always stay connected. WhatsApp and Facebook keep you in touch with friends, and you can watch YouTube or plan your next trip with Google Maps. Google Assistant gives you answers at the press of a button, and Wi-Fi, Bluetooth and A-GPS are included. There is a 3.5 mm headphone jack and a micro-USB port, storage can be expanded by up to 32 GB with a memory card, and the phone supports Dual SIM.',
            'description_translations' => [
                'de' => 'Bleiben Sie mit moderner Technik auf dem Laufenden. Das Nokia 8000 4G unterstützt schnelle LTE-Netze, damit Sie immer verbunden sind. WhatsApp und Facebook halten Sie mit Freunden in Kontakt, und Sie können YouTube schauen oder Ihre nächste Reise mit Google Maps planen. Der Google Assistant liefert Antworten per Knopfdruck, und WLAN, Bluetooth und A-GPS sind an Bord. Es gibt eine 3,5-mm-Kopfhörerbuchse und einen Micro-USB-Anschluss, der Speicher lässt sich per Speicherkarte um bis zu 32 GB erweitern, und das Handy unterstützt Dual SIM.',
                'sk' => 'Držte krok s modernými technológiami. Nokia 8000 4G podporuje rýchle mobilné siete LTE, zostanete tak vždy v spojení s okolitým svetom! Vďaka sociálnym a komunikačným platformám Whatsapp a Facebook sa ľahko spojíte s vašimi priateľmi, môžete tiež streemovať videá na YouTube alebo pomocou Google Map plánovať cestovateľské dobrodružstvo. Funkcia Asistenta Google zabezpečí potrebné informácie stlačením jedného tlačidla, poteší aj WiFi, Bluetooth a polohový senzor A-GPS! Pre počúvanie hudby je telefón vybavený 3,5 mm slúchadlovým konektorom, nechýba ani microUSB port. Interné úložisko možno navyše rozšíriť až o 32GB vďaka integrovanému slotu na pamäťovú kartu a telefón sa pýši aj Dual SIM!',
            ],
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
            'description' => 'Modern design, strong performance, 5G speed, a reliable battery, fast charging and a water-resistant body are just some of the advantages of the Sony Xperia 10 III. Its three lenses (wide, ultra-wide and telephoto) let you take striking portraits, snapshots and detailed landscapes. The automatic mode even recognises animals, adjusts exposure and keeps the picture as sharp as possible, whether it is a restaurant menu, a dim evening scene, a backlit face or movement. The phone also records 4K video.',
            'description_translations' => [
                'de' => 'Modernes Design, starke Leistung, 5G, ein zuverlässiger Akku, Schnellladen und ein wasserdichtes Gehäuse sind nur einige Vorteile des Sony Xperia 10 III. Drei Objektive (Weitwinkel, Ultraweitwinkel und Tele) ermöglichen eindrucksvolle Porträts, Schnappschüsse und detailreiche Landschaften. Der Automatikmodus erkennt sogar Tiere, passt die Belichtung an und sorgt für maximale Schärfe – ob Speisekarte, Abendstimmung, Gegenlicht oder Bewegung. Das Smartphone nimmt außerdem Videos in 4K auf.',
                'sk' => 'Moderný design, vysoký výkon, rýchlosť 5G, spoľahlivá batéria, rýchle nabíjanie, vodoodolné telo. To je iba niekoľko výhod modelu Sony Xperia 10 III. Ponúka tiež tri objektívy - širokouhlý, všestranný a teleobjektív, takže sa stanete autorom dych vyrážajúcich expresívnych portrétov, momentiek či záberov rôznorodej krajiny plných detailov. Automatický režim navyše ponúka funkciu rozoznávania zvierat, upraví expozíciu a dohliadne na to, aby bola fotografia maximálne ostrá. Podarí sa vám zachytiť menu v reštaurácii, podvečernú kompozíciu pri minimálnom osvetlení, detail tváre v protisvetle či pohyb. Telefón vyhotoví aj kvalitné videozáznamy v 4K rozlíšení (štvornásobok Full HD).',
            ],
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
            'description' => 'This smartphone wins you over with a unique water- and dust-resistant design and surprising battery life. Its biggest strength is the four-lens camera that automatically focuses even on moving subjects, with a sophisticated 3D iToF sensor and many modes. CineAlta technology lets you shoot films with colour and settings similar to those used by professional filmmakers, and you can review your work on the 4K HDR OLED display.',
            'description_translations' => [
                'de' => 'Dieses Smartphone überzeugt mit einem einzigartigen wasser- und staubdichten Design und überraschender Akkulaufzeit. Seine größte Stärke ist die Kamera mit vier Objektiven, die automatisch auch auf bewegte Motive scharfstellt, mit einem ausgefeilten 3D-iToF-Sensor und vielen Modi. Die CineAlta-Technologie ermöglicht Filmaufnahmen mit Farb- und Bildeinstellungen wie bei professionellen Filmemachern, und Ihre Werke betrachten Sie auf dem 4K-HDR-OLED-Display.',
                'sk' => 'Tento smartphone si vás získa unikátnym designom odolným voči vode i prachu a prekvapujúcou výdržou batérie. Jeho najdôležitejšou prednosťou je však fotoaparát so štyrmi objektívmi, ktorý automaticky zaostrí aj na pohybujúce sa objekty. Disponuje tiež sofistikovaným snímačom 3D iToF a množstvom režimov. Technológia CineAlta umožní nakrúcanie filmov s nastavením farieb a parametrov podobným tým, aké používajú profesionálni filmoví tvorcovia. Svoje výtvory si následne prezriete na inovovanom 4K HDR OLED displeji.',
            ],
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
            'description' => 'The Xperia 5 III is compact and powerful, combining the fast autofocus of its predecessor with new optics reaching up to 105 mm. Whether you are taking photos or gaming, it fits your hand and exceeds your expectations.',
            'description_translations' => [
                'de' => 'Das Xperia 5 III ist kompakt und leistungsstark und kombiniert den schnellen Autofokus seines Vorgängers mit einer neuen Optik bis 105 mm. Ob beim Fotografieren oder Spielen – es liegt gut in der Hand und übertrifft Ihre Erwartungen.',
                'sk' => 'Smartfón Xperia 5 III je kompaktný, výkonný a kombinuje rýchle AF jeho predchodcu s novou optikou s ohniskovou vzdialenosťou až 105 mm. Či už fotíte alebo hráte hry, padne vám do ruky a prekoná vaše očakávania.',
            ],
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
            'description' => 'The Nokia 150 combines a nice design with practicality. The polycarbonate body keeps its colour for years, and under the clear 2.4-inch colour display there are large, easy-to-press buttons.',
            'description_translations' => [
                'de' => 'Das Nokia 150 verbindet schönes Design mit Praxistauglichkeit. Das Polycarbonat-Gehäuse behält seine Farbe über Jahre, und unter dem übersichtlichen 2,4-Zoll-Farbdisplay liegen große, gut bedienbare Tasten.',
                'sk' => 'Nokia 150 v sebe snúbi pekný dizajn s praktickosťou. Telo telefónu si zachová vždy svojou farbu vďaka použitému polykarbonátu. Pod prehľadným 2,4" farebným displejom sa nachádzajú prehľadné veľké tlačidlá vďaka ktorým budeme mať vždy istý stisk.',
            ],
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

        $smartphone = new Smartphone([
            'name' => 'Samsung Galaxy S24 8GB/256GB',
            'price' => 799.00,
            'quantity' => 15,
            'brand_id' => 1,
            'color_id' => 8,
            'description' => 'A compact flagship that fits comfortably in one hand. The bright 120 Hz display adapts its refresh rate to what you are doing, and the triple camera with a 3x telephoto lens takes detailed photos day and night. Built-in AI features translate calls live, summarise notes and help you edit photos, and Samsung promises seven years of software updates.',
            'description_translations' => [
                'de' => 'Ein kompaktes Flaggschiff, das bequem in einer Hand liegt. Das helle 120-Hz-Display passt seine Bildwiederholrate an, und die Dreifachkamera mit 3-fach-Tele liefert detailreiche Fotos bei Tag und Nacht. Integrierte KI-Funktionen übersetzen Anrufe live, fassen Notizen zusammen und helfen bei der Bildbearbeitung, und Samsung verspricht sieben Jahre Software-Updates.',
                'sk' => 'Kompaktná vlajková loď, ktorá pohodlne padne do jednej ruky. Jasný 120 Hz displej prispôsobuje obnovovaciu frekvenciu tomu, čo práve robíte, a trojitý fotoaparát s 3× teleobjektívom zachytí detailné snímky vo dne aj v noci. Zabudované funkcie umelej inteligencie prekladajú hovory naživo, zhrnú poznámky a pomôžu s úpravou fotiek, a Samsung sľubuje sedem rokov aktualizácií softvéru.',
            ],
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.2,
            'resolution' => '2340 x 1080',
            'height' => 147.0,
            'width' => 70.6,
            'thickness' => 7.6,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Samsung Galaxy A55 5G 8GB/128GB',
            'price' => 399.00,
            'quantity' => 25,
            'brand_id' => 1,
            'color_id' => 3,
            'description' => 'A mid-range phone with a premium feel: a metal frame, a glass back and IP67 water and dust resistance. The large Super AMOLED display is smooth and vivid, the 50 MP main camera handles low light well, and the 5000 mAh battery easily lasts a full day.',
            'description_translations' => [
                'de' => 'Ein Mittelklasse-Handy mit Premium-Gefühl: Metallrahmen, Glasrückseite und Schutz vor Wasser und Staub nach IP67. Das große Super-AMOLED-Display ist flüssig und farbstark, die 50-MP-Hauptkamera meistert schwaches Licht gut, und der 5000-mAh-Akku hält locker einen ganzen Tag.',
                'sk' => 'Telefón strednej triedy s prémiovým pocitom: kovový rám, sklenená zadná strana a odolnosť voči vode a prachu IP67. Veľký Super AMOLED displej je plynulý a živý, 50 Mpx hlavný fotoaparát si dobre poradí so slabým svetlom a batéria 5000 mAh ľahko vydrží celý deň.',
            ],
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.6,
            'resolution' => '2340 x 1080',
            'height' => 161.1,
            'width' => 77.4,
            'thickness' => 8.2,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Samsung Galaxy Z Flip6 12GB/256GB',
            'price' => 1099.00,
            'quantity' => 5,
            'brand_id' => 1,
            'color_id' => 4,
            'description' => 'A full-size smartphone that folds in half to fit any pocket. The large cover screen shows notifications, widgets and a camera preview without opening the phone, and the hinge holds any angle for hands-free video calls and photos. The 50 MP main camera and a bigger battery make this the most capable Flip so far.',
            'description_translations' => [
                'de' => 'Ein vollwertiges Smartphone, das sich in der Mitte zusammenklappen lässt und in jede Tasche passt. Das große Außendisplay zeigt Benachrichtigungen, Widgets und eine Kameravorschau, ohne das Handy zu öffnen, und das Scharnier hält jeden Winkel für freihändige Videoanrufe und Fotos. Die 50-MP-Hauptkamera und ein größerer Akku machen es zum bisher stärksten Flip.',
                'sk' => 'Plnohodnotný smartfón, ktorý sa preloží na polovicu a zmestí sa do každého vrecka. Veľký vonkajší displej zobrazí upozornenia, widgety aj náhľad fotoaparátu bez otvorenia telefónu a pánt udrží akýkoľvek uhol pre videohovory a fotky bez držania v ruke. 50 Mpx hlavný fotoaparát a väčšia batéria z neho robia doteraz najschopnejší Flip.',
            ],
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.7,
            'resolution' => '2640 x 1080',
            'height' => 165.1,
            'width' => 71.9,
            'thickness' => 6.9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Apple iPhone 15 128GB',
            'price' => 849.00,
            'quantity' => 20,
            'brand_id' => 7,
            'color_id' => 6,
            'description' => 'The iPhone 15 brings the Dynamic Island, a 48 MP main camera and USB-C to the standard model. Photos are sharper, with automatic portrait mode and a 2x telephoto option, and the colour-infused glass back feels as good as it looks. The A16 Bionic chip keeps everything fast and efficient.',
            'description_translations' => [
                'de' => 'Das iPhone 15 bringt die Dynamic Island, eine 48-MP-Hauptkamera und USB-C in das Standardmodell. Fotos werden schärfer, mit automatischem Porträtmodus und 2-fach-Tele-Option, und die durchgefärbte Glasrückseite fühlt sich so gut an, wie sie aussieht. Der A16 Bionic Chip hält alles schnell und effizient.',
                'sk' => 'iPhone 15 prináša do základného modelu Dynamic Island, 48 Mpx hlavný fotoaparát a USB-C. Fotky sú ostrejšie, s automatickým portrétnym režimom a 2× priblížením, a zadná strana z farbeného skla na dotyk pôsobí rovnako dobre, ako vyzerá. Čip A16 Bionic udržiava všetko rýchle a úsporné.',
            ],
            'ram' => 6144,
            'operating_system' => 'iOS',
            'os_version' => 17,
            'display_size' => 6.1,
            'resolution' => '2556 x 1179',
            'height' => 147.6,
            'width' => 71.6,
            'thickness' => 7.8,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Apple iPhone 15 Pro 256GB',
            'price' => 1199.00,
            'quantity' => 8,
            'brand_id' => 7,
            'color_id' => 8,
            'description' => 'A light and strong titanium design, the customisable Action button and the A17 Pro chip with console-class graphics. The pro camera system includes a 48 MP main camera and a 3x telephoto lens, and USB 3 speeds make moving large videos to a computer quick.',
            'description_translations' => [
                'de' => 'Ein leichtes und robustes Titandesign, die anpassbare Aktionstaste und der A17 Pro Chip mit Grafik auf Konsolenniveau. Das Pro-Kamerasystem umfasst eine 48-MP-Hauptkamera und ein 3-fach-Teleobjektiv, und dank USB-3-Geschwindigkeit sind große Videos schnell auf dem Computer.',
                'sk' => 'Ľahký a pevný titánový dizajn, prispôsobiteľné tlačidlo Akcia a čip A17 Pro s grafikou na úrovni herných konzol. Profesionálny fotosystém zahŕňa 48 Mpx hlavný fotoaparát a 3× teleobjektív a vďaka rýchlosti USB 3 presuniete aj veľké videá do počítača za chvíľu.',
            ],
            'ram' => 8192,
            'operating_system' => 'iOS',
            'os_version' => 17,
            'display_size' => 6.1,
            'resolution' => '2556 x 1179',
            'height' => 146.6,
            'width' => 70.6,
            'thickness' => 8.25,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Apple iPhone SE 64GB (3rd generation)',
            'price' => 459.00,
            'quantity' => 0,
            'brand_id' => 7,
            'color_id' => 1,
            'description' => 'The classic compact iPhone with a Home button and Touch ID, powered by the same A15 Bionic chip as much more expensive models. It supports 5G, takes great photos with Smart HDR 4, and fits easily in one hand and any pocket.',
            'description_translations' => [
                'de' => 'Das klassische kompakte iPhone mit Home-Taste und Touch ID, angetrieben vom gleichen A15 Bionic Chip wie deutlich teurere Modelle. Es unterstützt 5G, macht dank Smart HDR 4 tolle Fotos und passt problemlos in eine Hand und jede Tasche.',
                'sk' => 'Klasický kompaktný iPhone s tlačidlom Domov a Touch ID, poháňaný rovnakým čipom A15 Bionic ako oveľa drahšie modely. Podporuje 5G, vďaka Smart HDR 4 robí skvelé fotky a ľahko sa zmestí do jednej ruky aj do každého vrecka.',
            ],
            'ram' => 4096,
            'operating_system' => 'iOS',
            'os_version' => 15,
            'display_size' => 4.7,
            'resolution' => '1334 x 750',
            'height' => 138.4,
            'width' => 67.3,
            'thickness' => 7.3,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Google Pixel 8 8GB/128GB',
            'price' => 699.00,
            'quantity' => 12,
            'brand_id' => 8,
            'color_id' => 2,
            'description' => 'Google\'s compact flagship with the Tensor G3 chip and seven years of Android updates. The camera uses Google\'s computational photography for excellent photos in any light, and tools like Magic Editor, Best Take and Audio Magic Eraser fix photos and videos after you take them.',
            'description_translations' => [
                'de' => 'Googles kompaktes Flaggschiff mit Tensor-G3-Chip und sieben Jahren Android-Updates. Die Kamera nutzt Googles Computational Photography für hervorragende Fotos bei jedem Licht, und Tools wie Magischer Editor, Bestes Foto und Audio-Magischer-Radierer verbessern Fotos und Videos nachträglich.',
                'sk' => 'Kompaktná vlajková loď od Googlu s čipom Tensor G3 a siedmimi rokmi aktualizácií Androidu. Fotoaparát využíva výpočtovú fotografiu Googlu na vynikajúce snímky pri akomkoľvek svetle a nástroje ako Magický editor, Najlepší záber či Magická guma na zvuk opravia fotky a videá aj dodatočne.',
            ],
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.2,
            'resolution' => '2400 x 1080',
            'height' => 150.5,
            'width' => 70.8,
            'thickness' => 8.9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Google Pixel 8a 8GB/128GB',
            'price' => 499.00,
            'quantity' => 18,
            'brand_id' => 8,
            'color_id' => 3,
            'description' => 'Most of the Pixel 8 experience at a lower price. The same Tensor G3 chip, the same seven years of updates and Google\'s AI features, with a smooth 120 Hz display and a camera that takes great photos without any effort.',
            'description_translations' => [
                'de' => 'Das meiste vom Pixel 8 zu einem niedrigeren Preis: derselbe Tensor-G3-Chip, dieselben sieben Jahre Updates und Googles KI-Funktionen, dazu ein flüssiges 120-Hz-Display und eine Kamera, die mühelos tolle Fotos macht.',
                'sk' => 'Väčšina toho, čo ponúka Pixel 8, za nižšiu cenu: rovnaký čip Tensor G3, rovnakých sedem rokov aktualizácií a funkcie umelej inteligencie od Googlu, k tomu plynulý 120 Hz displej a fotoaparát, ktorý bez námahy robí skvelé fotky.',
            ],
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.1,
            'resolution' => '2400 x 1080',
            'height' => 152.1,
            'width' => 72.7,
            'thickness' => 8.9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Xiaomi 14 12GB/512GB',
            'price' => 899.00,
            'quantity' => 7,
            'brand_id' => 3,
            'color_id' => 7,
            'description' => 'A compact flagship with Leica optics. The three 50 MP cameras, including a floating telephoto lens, produce natural, detailed photos, and the Snapdragon 8 Gen 3 chip handles anything. The 4610 mAh battery charges from empty to full in about half an hour with the 90 W charger.',
            'description_translations' => [
                'de' => 'Ein kompaktes Flaggschiff mit Leica-Optik. Die drei 50-MP-Kameras, darunter ein schwebendes Teleobjektiv, liefern natürliche, detailreiche Fotos, und der Snapdragon 8 Gen 3 meistert alles. Der 4610-mAh-Akku ist mit dem 90-W-Ladegerät in etwa einer halben Stunde voll.',
                'sk' => 'Kompaktná vlajková loď s optikou Leica. Tri 50 Mpx fotoaparáty vrátane plávajúceho teleobjektívu vytvárajú prirodzené a detailné snímky a čip Snapdragon 8 Gen 3 zvládne čokoľvek. Batériu s kapacitou 4610 mAh nabije 90 W nabíjačka z nuly na plno približne za pol hodiny.',
            ],
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.36,
            'resolution' => '2670 x 1200',
            'height' => 152.8,
            'width' => 71.5,
            'thickness' => 8.2,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Xiaomi Redmi Note 13 Pro 8GB/256GB',
            'price' => 329.00,
            'quantity' => 30,
            'brand_id' => 3,
            'color_id' => 5,
            'description' => 'A 200 MP main camera with optical image stabilisation in an affordable phone. The large 120 Hz AMOLED display is bright enough for direct sunlight, and 67 W turbo charging gets you through the day after a short break.',
            'description_translations' => [
                'de' => 'Eine 200-MP-Hauptkamera mit optischer Bildstabilisierung in einem erschwinglichen Handy. Das große 120-Hz-AMOLED-Display ist hell genug für direktes Sonnenlicht, und 67-W-Turboladen bringt Sie nach einer kurzen Pause durch den Tag.',
                'sk' => '200 Mpx hlavný fotoaparát s optickou stabilizáciou obrazu v cenovo dostupnom telefóne. Veľký 120 Hz AMOLED displej je dosť jasný aj na priame slnko a 67 W turbo nabíjanie vás po krátkej prestávke dostane cez celý deň.',
            ],
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 13,
            'display_size' => 6.67,
            'resolution' => '2712 x 1220',
            'height' => 161.2,
            'width' => 74.2,
            'thickness' => 8.0,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'OnePlus 12 12GB/256GB',
            'price' => 899.00,
            'quantity' => 10,
            'brand_id' => 9,
            'color_id' => 2,
            'description' => 'A fast flagship with a brilliant 2K display, the Snapdragon 8 Gen 3 chip and a Hasselblad-tuned triple camera. The 5400 mAh battery lasts well over a day and charges fully in under half an hour, wired or even wirelessly at 50 W.',
            'description_translations' => [
                'de' => 'Ein schnelles Flaggschiff mit brillantem 2K-Display, Snapdragon 8 Gen 3 und einer von Hasselblad abgestimmten Dreifachkamera. Der 5400-mAh-Akku hält gut über einen Tag und ist in unter einer halben Stunde voll – kabelgebunden oder sogar kabellos mit 50 W.',
                'sk' => 'Rýchla vlajková loď s brilantným 2K displejom, čipom Snapdragon 8 Gen 3 a trojitým fotoaparátom ladeným s Hasselbladom. Batéria 5400 mAh vydrží viac ako deň a nabije sa za menej ako pol hodiny – káblom aj bezdrôtovo výkonom 50 W.',
            ],
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.82,
            'resolution' => '3168 x 1440',
            'height' => 164.3,
            'width' => 75.8,
            'thickness' => 9.15,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'OnePlus Nord 4 12GB/256GB',
            'price' => 449.00,
            'quantity' => 14,
            'brand_id' => 9,
            'color_id' => 9,
            'description' => 'A rare metal unibody design in the mid-range. It is smooth and fast thanks to the Snapdragon 7+ Gen 3 chip, has a large 120 Hz OLED display, and its 5500 mAh battery charges from 1 to 100 % in about half an hour.',
            'description_translations' => [
                'de' => 'Ein seltenes Unibody-Design aus Metall in der Mittelklasse. Dank Snapdragon 7+ Gen 3 läuft es flüssig und schnell, hat ein großes 120-Hz-OLED-Display, und der 5500-mAh-Akku lädt in etwa einer halben Stunde von 1 auf 100 %.',
                'sk' => 'Vzácny kovový unibody dizajn v strednej triede. Vďaka čipu Snapdragon 7+ Gen 3 je plynulý a rýchly, má veľký 120 Hz OLED displej a jeho batéria s kapacitou 5500 mAh sa nabije z 1 na 100 % približne za pol hodiny.',
            ],
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.74,
            'resolution' => '2772 x 1240',
            'height' => 162.6,
            'width' => 75.0,
            'thickness' => 8.0,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Motorola Edge 50 Pro 12GB/512GB',
            'price' => 549.00,
            'quantity' => 9,
            'brand_id' => 10,
            'color_id' => 5,
            'description' => 'A curved 144 Hz pOLED display and a vegan-leather back give this phone a premium look. The 50 MP camera system is colour-validated by Pantone for true-to-life skin tones, and 125 W TurboPower charging gives you a day\'s power in minutes.',
            'description_translations' => [
                'de' => 'Ein gewölbtes 144-Hz-pOLED-Display und eine Rückseite aus veganem Leder verleihen diesem Handy einen edlen Look. Das 50-MP-Kamerasystem ist von Pantone farbvalidiert für naturgetreue Hauttöne, und TurboPower-Laden mit 125 W liefert Energie für einen Tag in wenigen Minuten.',
                'sk' => 'Zakrivený 144 Hz pOLED displej a zadná strana z vegánskej kože dodávajú telefónu prémiový vzhľad. 50 Mpx fotosystém má farby overené spoločnosťou Pantone pre verné odtiene pleti a nabíjanie TurboPower s výkonom 125 W vám dodá energiu na celý deň za pár minút.',
            ],
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.7,
            'resolution' => '2712 x 1220',
            'height' => 161.2,
            'width' => 72.4,
            'thickness' => 8.2,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Motorola Moto G54 5G 8GB/256GB',
            'price' => 199.00,
            'quantity' => 40,
            'brand_id' => 10,
            'color_id' => 3,
            'description' => 'Plenty of phone for the price: 5G, 256 GB of storage, a smooth 120 Hz display and stereo speakers with Dolby Atmos. The 5000 mAh battery easily lasts two days of normal use.',
            'description_translations' => [
                'de' => 'Viel Handy fürs Geld: 5G, 256 GB Speicher, ein flüssiges 120-Hz-Display und Stereolautsprecher mit Dolby Atmos. Der 5000-mAh-Akku hält bei normaler Nutzung locker zwei Tage.',
                'sk' => 'Veľa telefónu za rozumnú cenu: 5G, 256 GB úložiska, plynulý 120 Hz displej a stereo reproduktory s Dolby Atmos. Batéria 5000 mAh pri bežnom používaní ľahko vydrží dva dni.',
            ],
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 13,
            'display_size' => 6.5,
            'resolution' => '2400 x 1080',
            'height' => 161.6,
            'width' => 73.8,
            'thickness' => 8.0,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Honor Magic6 Pro 12GB/512GB',
            'price' => 1299.00,
            'quantity' => 3,
            'brand_id' => 11,
            'color_id' => 9,
            'description' => 'Honor\'s flagship with a 180 MP periscope telephoto camera and a very bright, eye-friendly display. The silicon-carbon battery packs 5600 mAh into a slim body, and the reinforced glass makes the screen highly resistant to drops.',
            'description_translations' => [
                'de' => 'Honors Flaggschiff mit 180-MP-Periskop-Telekamera und einem sehr hellen, augenschonenden Display. Der Silizium-Kohlenstoff-Akku bringt 5600 mAh in ein schlankes Gehäuse, und das verstärkte Glas macht den Bildschirm besonders sturzfest.',
                'sk' => 'Vlajková loď značky Honor so 180 Mpx periskopickým teleobjektívom a veľmi jasným displejom šetrným k očiam. Kremíkovo-uhlíková batéria vtesná 5600 mAh do tenkého tela a zosilnené sklo robí obrazovku mimoriadne odolnou voči pádom.',
            ],
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.8,
            'resolution' => '2800 x 1280',
            'height' => 162.5,
            'width' => 75.8,
            'thickness' => 8.9,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Honor 200 12GB/512GB',
            'price' => 499.00,
            'quantity' => 0,
            'brand_id' => 11,
            'color_id' => 2,
            'description' => 'A slim, light phone built for portraits. The camera system and its studio-style portrait modes were developed with the Parisian photo studio Harcourt, and the curved OLED display and 100 W charging round off the package.',
            'description_translations' => [
                'de' => 'Ein schlankes, leichtes Handy für Porträts. Das Kamerasystem und seine Studio-Porträtmodi wurden mit dem Pariser Fotostudio Harcourt entwickelt, und das gewölbte OLED-Display sowie 100-W-Laden runden das Paket ab.',
                'sk' => 'Tenký a ľahký telefón stvorený na portréty. Fotosystém a jeho štúdiové portrétne režimy vznikli v spolupráci s parížskym fotoateliérom Harcourt a zakrivený OLED displej spolu so 100 W nabíjaním dopĺňajú celok.',
            ],
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.7,
            'resolution' => '2664 x 1200',
            'height' => 161.5,
            'width' => 74.8,
            'thickness' => 7.7,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Fairphone 5 8GB/256GB',
            'price' => 699.00,
            'quantity' => 6,
            'brand_id' => 12,
            'color_id' => 3,
            'description' => 'The sustainable choice: a modular phone you can repair yourself with a single screwdriver, made with fair and recycled materials. The battery, screen, cameras and other parts are replaceable, and Fairphone plans software support until 2031.',
            'description_translations' => [
                'de' => 'Die nachhaltige Wahl: ein modulares Handy, das Sie mit einem einzigen Schraubendreher selbst reparieren können, hergestellt aus fairen und recycelten Materialien. Akku, Display, Kameras und weitere Teile sind austauschbar, und Fairphone plant Software-Support bis 2031.',
                'sk' => 'Udržateľná voľba: modulárny telefón, ktorý si opravíte sami jediným skrutkovačom, vyrobený z férových a recyklovaných materiálov. Batéria, displej, fotoaparáty aj ďalšie diely sú vymeniteľné a Fairphone plánuje softvérovú podporu až do roku 2031.',
            ],
            'ram' => 8192,
            'operating_system' => 'Android',
            'os_version' => 13,
            'display_size' => 6.46,
            'resolution' => '2770 x 1224',
            'height' => 161.6,
            'width' => 75.8,
            'thickness' => 9.6,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Nothing Phone (2) 12GB/256GB',
            'price' => 599.00,
            'quantity' => 11,
            'brand_id' => 13,
            'color_id' => 7,
            'description' => 'A transparent back with the unique Glyph interface: light strips that show notifications, charging progress and timers so you can keep the screen face down. Nothing OS is clean and fast, and the dual 50 MP camera takes sharp photos.',
            'description_translations' => [
                'de' => 'Eine transparente Rückseite mit dem einzigartigen Glyph Interface: Lichtstreifen zeigen Benachrichtigungen, Ladefortschritt und Timer an, sodass der Bildschirm nach unten liegen kann. Nothing OS ist schlank und schnell, und die duale 50-MP-Kamera macht scharfe Fotos.',
                'sk' => 'Priehľadná zadná strana s jedinečným rozhraním Glyph: svetelné pásiky zobrazujú upozornenia, priebeh nabíjania aj časovače, takže telefón môže ležať obrazovkou nadol. Nothing OS je čistý a rýchly a duálny 50 Mpx fotoaparát robí ostré fotky.',
            ],
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 13,
            'display_size' => 6.7,
            'resolution' => '2412 x 1080',
            'height' => 162.1,
            'width' => 76.4,
            'thickness' => 8.6,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Sony Xperia 1 VI 12GB/256GB',
            'price' => 1399.00,
            'quantity' => 4,
            'brand_id' => 6,
            'color_id' => 9,
            'description' => 'Sony\'s flagship for creators, with camera technology from its Alpha cameras. The telephoto lens zooms continuously from 85 to 170 mm, and the phone keeps rare extras such as a headphone jack, a microSD slot and a two-stage shutter button.',
            'description_translations' => [
                'de' => 'Sonys Flaggschiff für Kreative mit Kameratechnik aus den Alpha-Kameras. Das Teleobjektiv zoomt stufenlos von 85 bis 170 mm, und das Handy bietet seltene Extras wie Kopfhörerbuchse, microSD-Steckplatz und einen zweistufigen Auslöser.',
                'sk' => 'Vlajková loď od Sony pre tvorcov s technológiou z fotoaparátov Alpha. Teleobjektív plynule približuje od 85 do 170 mm a telefón si zachováva vzácne výhody, ako konektor na slúchadlá, slot na microSD kartu a dvojstupňovú spúšť.',
            ],
            'ram' => 12288,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.5,
            'resolution' => '2340 x 1080',
            'height' => 162.0,
            'width' => 74.0,
            'thickness' => 8.2,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Nokia G42 5G 6GB/128GB',
            'price' => 199.00,
            'quantity' => 22,
            'brand_id' => 5,
            'color_id' => 5,
            'description' => 'An affordable 5G phone designed to be repaired: the battery, display and charging port can be replaced at home in minutes with the QuickFix guides. It has a 50 MP triple camera, a battery that lasts up to three days and two years of Android updates.',
            'description_translations' => [
                'de' => 'Ein erschwingliches 5G-Handy, das auf Reparierbarkeit ausgelegt ist: Akku, Display und Ladeanschluss lassen sich mit den QuickFix-Anleitungen in Minuten zu Hause tauschen. Es hat eine 50-MP-Dreifachkamera, einen Akku für bis zu drei Tage und zwei Jahre Android-Updates.',
                'sk' => 'Cenovo dostupný 5G telefón navrhnutý tak, aby sa dal opraviť: batériu, displej aj nabíjací port vymeníte doma za pár minút podľa návodov QuickFix. Má 50 Mpx trojitý fotoaparát, batériu, ktorá vydrží až tri dni, a dva roky aktualizácií Androidu.',
            ],
            'ram' => 6144,
            'operating_system' => 'Android',
            'os_version' => 13,
            'display_size' => 6.56,
            'resolution' => '1612 x 720',
            'height' => 165.0,
            'width' => 75.8,
            'thickness' => 8.55,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Huawei nova 12 SE 8GB/256GB',
            'price' => 299.00,
            'quantity' => 13,
            'brand_id' => 2,
            'color_id' => 7,
            'description' => 'A slim, elegant phone with a 108 MP main camera and a large OLED display. It charges quickly at 66 W and offers plenty of storage for photos and videos.',
            'description_translations' => [
                'de' => 'Ein schlankes, elegantes Handy mit 108-MP-Hauptkamera und großem OLED-Display. Es lädt schnell mit 66 W und bietet viel Speicher für Fotos und Videos.',
                'sk' => 'Tenký a elegantný telefón so 108 Mpx hlavným fotoaparátom a veľkým OLED displejom. Rýchlo sa nabíja výkonom 66 W a ponúka veľa miesta na fotky aj videá.',
            ],
            'ram' => 8192,
            'operating_system' => 'EMUI',
            'os_version' => 14,
            'display_size' => 6.67,
            'resolution' => '2400 x 1080',
            'height' => 161.0,
            'width' => 74.9,
            'thickness' => 7.3,
        ]);
        $smartphone->save();

        $smartphone = new Smartphone([
            'name' => 'Nokia 3210 4G (2024)',
            'price' => 79.99,
            'quantity' => 2,
            'brand_id' => 5,
            'color_id' => 4,
            'description' => 'The legendary Nokia 3210 is back, 25 years later, with 4G, a colour screen, a 2 MP camera, Bluetooth and USB-C. The battery lasts for days, Snake is of course included, and it is the perfect phone for a digital detox or as a backup.',
            'description_translations' => [
                'de' => 'Das legendäre Nokia 3210 ist zurück – 25 Jahre später, mit 4G, Farbdisplay, 2-MP-Kamera, Bluetooth und USB-C. Der Akku hält tagelang, Snake ist natürlich dabei, und es ist das perfekte Handy für einen Digital Detox oder als Zweitgerät.',
                'sk' => 'Legendárna Nokia 3210 je späť – o 25 rokov neskôr, so 4G, farebným displejom, 2 Mpx fotoaparátom, Bluetoothom a USB-C. Batéria vydrží celé dni, Snake nesmie chýbať a je to ideálny telefón na digitálny detox alebo ako záloha.',
            ],
            'ram' => 64,
            'operating_system' => 'S30+',
            'os_version' => null,
            'display_size' => 2.4,
            'resolution' => '320 x 240',
            'height' => 122.0,
            'width' => 52.0,
            'thickness' => 13.1,
        ]);
        $smartphone->save();
    }
}
