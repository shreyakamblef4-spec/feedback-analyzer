<?php
include 'db.php';

$text = strtolower($_POST['text']); // convert to lowercase

// --- Sentiment word lists ---
$positive_words = ["good","great","excellent","happy","love","amazing"];
$negative_words = ["bad","poor","sad","hate","worst","terrible"];

$pos = 0;
$neg = 0;

// count positive words
foreach ($positive_words as $word) {
    if (strpos($text, $word) !== false) {
        $pos++;
    }
}

// count negative words
foreach ($negative_words as $word) {
    if (strpos($text, $word) !== false) {
        $neg++;
    }
}

// decide sentiment
if ($pos > $neg) {
    $sentiment = "Positive";
} elseif ($neg > $pos) {
    $sentiment = "Negative";
} else {
    $sentiment = "Neutral";
}

// --- Keyword extraction ---
$stopwords = ["the","is","and","a","to","of","it","in"];

$words = explode(" ", $text);
$keywords = [];

foreach ($words as $w) {
    if (!in_array($w, $stopwords) && strlen($w) > 3) {
        $keywords[] = $w;
    }
}

// remove duplicates
$keywords = array_unique($keywords);
$keywords_str = implode(", ", $keywords);

// insert into database
$sql = "INSERT INTO feedback (text, sentiment, keywords)
        VALUES ('$text', '$sentiment', '$keywords_str')";

mysqli_query($conn, $sql);

// redirect back
header("Location: index.php");
?>