<?php
/*
  Author: Teodora
  Date: 07.11.2025
  Description: Movie recommendation application
*/

$file = "antworten.txt";
// introduction
$file = "antworten.txt";
echo "Willkommen zum Filmempfehlungsprogramm!\n";
echo "Bitte beantworten Sie die folgenden Fragen korrekt, um eine präzise Empfehlung zu erhalten.\n";

// all movies
$movies = [
    ["Ziemlich beste Freunde", 8.5, 112, 16, ["Komödie", "Drama"], "Der querschnittsgelähmte Philippe engagiert Driss, einen Ex-Häftling, als Betreuer. Trotz Unterschiede entsteht eine tiefe Freundschaft, die ihr Leben verändert."],
    ["Grand Budapest Hotel", 8.1, 99, 12, ["Komödie", "Drama"], "Abenteuerliche Geschichte eines legendären Concierge und seines Schützlings, die in Diebstahl, Vermögen und den Wandel Europas verwickelt werden."],
    ["Die Truman Show", 8.2, 103, 12, ["Komödie","Drama","Sci-Fi"], "Truman lebt sein Leben in einer perfekt inszenierten TV-Show, ohne zu wissen, dass jede Bewegung überwacht wird."],
    ["Bridget Jones - Am Rande des Wahnsinns", 6.8, 97, 12, ["Komödie","Drama","Liebesfilm"], "Bridget kämpft mit ihrem Alltag, Tagebuch und Liebeschaos, während sie versucht, ihr Leben selbst in die Hand zu nehmen."],
    ["Fight Club", 8.8, 139, 18, ["Krimi","Drama","Thriller"], "Ein namenloser Mann gründet einen geheimen Fight Club und wird in eine Spirale von Macht, Gewalt und Selbstfindung gezogen."],
    ["The Dark Knight Rises", 8.4, 164, 12, ["Action","Krimi","Drama","Thriller"], "Batman muss die Stadt retten, während Bane die Kontrolle übernimmt und Chaos verbreitet."],
    ["Catch Me If You Can", 8.1, 141, 6, ["Biografie","Krimi","Drama"], "Frank Abagnale Jr. täuscht verschiedene Identitäten vor, um Millionen zu stehlen, während ein FBI-Agent ihn jagt."],
    ["Ist das Leben nicht schön?", 8.6, 130, 6, ["Drama","Familienfilm","Fantasy","Liebesfilm"], "George Bailey erkennt an Weihnachten den Wert seines Lebens und die Bedeutung von Hoffnung und Zusammenhalt."],
    ["Das zauberhafte Land", 8.1, 102, 0, ["Abenteuer","Familienfilm","Fantasy","Musical"], "Dorothy landet in Oz und folgt der Gelben Ziegelstraße, um den Zauberer zu treffen, dabei trifft sie neue Freunde."],
    ["Die Monster AG", 8.1, 92, 6, ["Animation","Abenteuer","Komödie","Familienfilm","Fantasy"], "Monster Sulley und Mike müssen ein kleines Mädchen, das versehentlich in ihre Welt gelangt, zurückbringen."],
    ["Demon Slayer: Mugen Train", 8.2, 117, 16, ["Animation","Action","Abenteuer","Fantasy","Thriller"], "Tanjiro und seine Freunde besteigen den Unendlichen Zug, um einen gefährlichen Dämon zu besiegen."],
    ["Mein Nachbar Totoro", 8.1, 86, 0, ["Animation","Familienfilm","Fantasy"], "Zwei Schwestern entdecken magische Wesen in ihrem neuen Zuhause auf dem Land."],
    ["Paranormal Activity", 6.3, 86, 16, ["Horror","Mystery"], "Ein Paar wird in ihrem neuen Haus von einer geheimnisvollen Präsenz heimgesucht."],
    ["Five Nights at Freddy's", 5.4, 109, 16, ["Horror","Mystery","Thriller"], "Ein junger Mann entdeckt in einer verlassenen Pizzeria rachsüchtige Animatronics und kämpft um sein Überleben."],
    ["Orphan - Das Waisenkind", 7.0, 123, 16, ["Horror","Mystery","Thriller"], "Ein adoptiertes Mädchen entpuppt sich als manipulative Gefahr für ihre neue Familie."]
];
function filterByAge(array $filme, int $age): array {
    $result = [];
    foreach ($filme as $film) {
        if ($age >= $film[3]) {
            $result[] = $film;
        }
    }
    return $result;
}

// Questions
$responds = [];
$age = (int) readline ("1. Wie alt sind Sie? ");
$responds[] = "Alter: $age";
$choice = filterByAge($movies, $age);

$rating = strtolower(trim(readline("2. Ist Ihnen die Filmbewertung wichtig? (ja/nein): ")));
$responds[] = "Bewertung wichtig: $rating";

$length = strtolower(trim(readline("3. Bevorzugen Sie kurze (<100 Min.) oder lange (>100 Min.) Filme? (kurz/lang): ")));
$responds[] = "Länge: $length";

do {
    $genre = strtolower(trim(readline("4. Welches Genre bevorzugen Sie? (z.B. Komoedie, Drama, Action, Thriller): ")));
} while (!preg_match("/^[A-Za-z]+$/", $genre));



$end = strtolower(trim(readline("5. Happy End oder realistisch/tragisch? (happy/realistisch): ")));
$responds[] = "Ende: $end";

$preferences  = strtolower(trim(readline("6. Schauen Sie lieber allein oder mit anderen? (allein/gemeinsam): ")));
$responds[] = "Vorliebe: $preferences ";

// saves responds in file
file_put_contents($file, implode("\n", $responds));

// Counts points based on responds
$punkte = array_fill(0, count($movies), 0);
for ($i = 0; $i < count($movies); $i++) {
    $film = $movies[$i];
    // age
    if (in_array($film, $choice)) $punkte[$i]++;
    // rating
    if ($rating === "ja" && $film[1] >= 8) $punkte[$i]++;
    // lenght
    if ($length === "kurz" && $film[2] < 100) $punkte[$i]++;
    if ($length === "lang" && $film[2] > 100) $punkte[$i]++;
    // genre
    foreach ($film[4] as $g) {
        if (strtolower($g) === $genre) {
            $punkte[$i]++;
            break;
        }
    }
    // end
    $happy = ["Ziemlich beste Freunde","Grand Budapest Hotel","Catch Me If You Can","Bridget Jones - Am Rande des Wahnsinns","Ist das Leben nicht schön?","Das zauberhafte Land","Die Monster AG","Mein Nachbar Totoro"];
    $real = ["Fight Club","The Dark Knight Rises","Die Truman Show","Demon Slayer: Mugen Train","Paranormal Activity","Five Nights at Freddy's","Orphan - Das Waisenkind"];
    if ($end === "happy" && in_array($film[0], $happy)) $punkte[$i]++;
    if ($end === "realistisch" && in_array($film[0], $real)) $punkte[$i]++;

    // prefrences
    $alone = ["Fight Club","Die Truman Show","The Dark Knight Rises","Demon Slayer: Mugen Train","Orphan - Das Waisenkind","Paranormal Activity","Five Nights at Freddy's"];
    $company = ["Ziemlich beste Freunde","Grand Budapest Hotel","Bridget Jones - Am Rande des Wahnsinns","Das zauberhafte Land","Die Monster AG","Mein Nachbar Totoro","Ist das Leben nicht schön?","Catch Me If You Can"];
    if ($preferences  === "allein" && in_array($film[0], $alone)) $punkte[$i]++;
    if ($preferences  === "gemeinsam" && in_array($film[0], $company)) $punkte[$i]++;
}

// recommendation
echo "---------------------------\n";
$maxPunkte = max($punkte);
echo "\nUnsere Empfehlung:\n\n";
for ($i = 0; $i < count($movies); $i++) {
    if ($punkte[$i] === $maxPunkte) {
        $film = $movies[$i];
        echo "Titel: " . $film[0] . "\n";
        echo "Bewertung: " . $film[1] . "/10\n";
        echo "Dauer: " . $film[2] . " Min.\n";
        echo "Altersfreigabe: " . $film[3] . "\n";
        echo "Genres: " . implode(", ", $film[4]) . "\n";
        echo "Handlung: " . $film[5] . "\n";
        echo "---------------------------\n";
    }
}
?>
