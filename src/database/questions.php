<?php

function getQuestion($questionId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM "Content", "Question" WHERE "contentId" = ?');
    $stmt->execute([$questionId]);
    return $stmt->fetch();
}

function getDescendantsOfContent($contentId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM "Reply" WHERE "parentId" = ?');
    $stmt->execute([$contentId]);
    $descendants = $stmt->fetchAll();
    foreach ($descendants as $descendant) {
        $descendant->children = getDescendantsOfContent($descendant['contentId']);
    }
    return $descendants;
}

function getQuestionHierarchy($questionId)
{
    $question = getQuestion($questionId);
    $question->children = getDescendantsOfContent($question);
    return $question;
}

function getContentById($id){
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM "Content", "Question" WHERE "id" = ?');
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getQuestionByString($inputString){
    global $conn;

    $expression = '%'.$inputString.'%';

    $stmt = $conn->prepare('SELECT "contentId" FROM "Question" WHERE "title" LIKE ?');
    $stmt->execute([$expression]);
    $questions = $stmt->fetchAll();

    $lookALikeQuestions = array();

    foreach ($questions as $question){
        $lookALikeQuestions[] = getContentById($question['contentId']);
    }

    return $lookALikeQuestions;

}
