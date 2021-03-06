<?php


function register($email, $password, $name)
{
    global $conn;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('INSERT INTO "User" (email,password,name,"privilegeLevelId") VALUES (?,?,?,?) RETURNING "id", "email", "name", "privilegeLevelId"');
    $stmt->execute([$email, $hashed_password, $name, 4]);

    return $stmt->fetch();
}

function banUser($explanation, $expires, $reason, $userId)
{
    global $conn;
    $stmt = $conn->prepare('INSERT INTO "BannedUser" (explanation, expires, reason, "userId") VALUES (?,?,?,?) RETURNING "explanation", "expires", "reason", "userId"');
    $stmt->execute([$explanation, $expires, $reason, $userId]);
    return $stmt->fetch();
}


function login($email, $password)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "id", "name", "password", "photo", "email", "signupDate" FROM "User" WHERE "User".email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    $userPassword = $user['password'];
    unset($user['password']);

    if (password_verify($password, $userPassword))
        return $user;
    else
        return false;
}
function checkCurrentPassword($id, $currentPassword){

    global $conn;
    $stmt = $conn->prepare('SELECT * FROM "User" WHERE "User".id = ?');
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if (password_verify($currentPassword, $user['password']))
        return true;
    else
        return false;
}



function changePassword($id, $newPassword){

    //FIXME: untested
    global $conn;

    try {
        $conn->query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
        $conn->beginTransaction();
        $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('UPDATE "User" SET "password" = ? WHERE "id" = ?;');
        $stmt->execute([$hashed_password, $id]);
        $conn->commit();

    } catch (PDOException $exception) {
        //$conn->rollBack();
        {
            echo $stmt . "<br>" . $exception->getMessage();
        }

        //$conn = null;
    }

}

function getUserNameById($id)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "User"."name" FROM "User" WHERE "User".id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch()["name"];
}

function getUserEmailById($id)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "User"."email" FROM "User" WHERE "User".id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch()["email"];
}

function getUserPhotoById($id)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "User"."photo" FROM "User" WHERE "User".id = ?');
    $stmt->execute([$id]);
    $photo = $stmt->fetch()["photo"];
    if ($photo == NULL)
        return "user-default.png";
    else
        return $photo;
}

function getUserBioById($id)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "User"."bio" FROM "User" WHERE "User".id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch()["bio"];
}

function getUserById($userId)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "User" WHERE "id" = ?');
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

function getUnreadNotifications($userId)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "Notification" WHERE "userId" = ? AND read = FALSE');
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function getNumberOfUnreadNotifications($userId){
    global $conn;
    $stmt = $conn->prepare('SELECT COUNT(*) FROM "Notification" WHERE "userId" = ? AND read = FALSE');
    $stmt->execute([$userId]);
    return $stmt->fetch()['count'];

}

function getNumberOfReadNotifications($userId){
    global $conn;
    $stmt = $conn->prepare('SELECT COUNT(*) FROM "Notification" WHERE "userId" = ? AND read = TRUE');
    $stmt->execute([$userId]);
    return $stmt->fetch()['count'];
}

function getReadNotifications($userId)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "Notification" WHERE "userId" = ? AND read = TRUE');
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}


function getNumberOfUsersByName($inputString)
{
    global $conn;

    $expression = '%' . $inputString . '%';

    $stmt = $conn->prepare('SELECT COUNT(*) FROM "User" WHERE "name" LIKE ?');
    $stmt->execute([$expression]);
    return $stmt->fetch();
}

function getUserQuestions($userId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM "Content", "Question" WHERE "creatorId" = ? AND "contentId" = "Content".id');
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function getUserQuestionAnswered($userId)
{
    global $conn;
    $stmt = $conn->prepare(
        'SELECT DISTINCT ON ("Question"."contentId") "Question"."contentId", "Question"."title", "Question"."closed", "Question"."numReplies", "Content"."creatorId", "Content"."creationDate", "Content"."rating", "Content"."id"
		FROM "Question", "Content", "Reply"
			WHERE "creatorId" = ? 
			AND "Reply"."contentId" = "Content".id 
			AND "questionId" = "Question"."contentId"');
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function getQuestionFromTopContent($topContentId)
{
    global $conn;
    $topContentId = '{' . $topContentId . '}';
    $stmt = $conn->prepare('SELECT * FROM "Content", "Question", unnest(?::INTEGER[]) AS "questions" WHERE "Content"."id" = "Question"."contentId" AND "Content"."id" = "questions";');
    $stmt->execute([$topContentId]);
    return $stmt->fetchAll();
}


function getNumberUserQuestions($userId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT COUNT(*) FROM "Content", "Question" WHERE "creatorId" = ? AND "contentId" = "Content".id');
    $stmt->execute([$userId]);
    return $stmt->fetch()['count'];
}

function getNumberUserReply($userId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT COUNT(*) FROM(SELECT DISTINCT ON ("Question"."contentId") "Question"."contentId", "Question"."title", "Question"."closed", "Question"."numReplies", "Content"."creatorId", "Content"."creationDate", "Content"."rating"
		FROM "Question", "Content", "Reply"
			WHERE "creatorId" = ? 
			AND "Reply"."contentId" = "Content".id 
			AND "questionId" = "Question"."contentId") as a');
    $stmt->execute([$userId]);
    return $stmt->fetch()['count'];
}

function getOrderedUsersByName($name, $offset, $limit, $order)
{
    global $conn;

    switch ($order) {
        case UserSearchOrder::NUM_QUESTIONS_ASC:
            $orderCriteria = '(SELECT COUNT(*) FROM "Question", "Content" WHERE id = "contentId" GROUP BY "creatorId")';
            $orderDirection = 'ASC';
            break;
        case UserSearchOrder::NUM_QUESTIONS_DESC:
            $orderCriteria = '(SELECT COUNT(*) FROM "Question", "Content" WHERE id = "contentId" GROUP BY "creatorId")';
            $orderDirection = 'DESC';
            break;
        case UserSearchOrder::NUM_REPLIES_ASC:
            $orderCriteria = '(SELECT COUNT(*) FROM "Reply", "Content" WHERE id = "contentId" GROUP BY "creatorId")';
            $orderDirection = 'ASC';
            break;
        case UserSearchOrder::NUM_REPLIES_DESC:
            $orderCriteria = '(SELECT COUNT(*) FROM "Reply", "Content" WHERE id = "contentId" GROUP BY "creatorId")';
            $orderDirection = 'DESC';
            break;
        case UserSearchOrder::JOIN_DATE_ASC:
            $orderCriteria = '"signupDate"';
            $orderDirection = 'ASC';
            break;
        default:
            $orderCriteria = '"signupDate"';
            $orderDirection = 'DESC';
            break;
    }


    try {
        $conn->beginTransaction();
        $countStmt = $conn->prepare('SELECT Count(*) FROM "User" WHERE "name" ~~* ?');
        $countStmt->execute(['%' . $name . '%']);
        $searchStmt = $conn->prepare('SELECT "id", "email", "photo","name", "signupDate"  FROM "User" WHERE "name" ~~* ? ORDER BY ? LIMIT ? OFFSET ?');
        $searchStmt->execute(['%' . $name . '%', $orderCriteria . ' ' . $orderDirection, $limit, $offset]);

        $conn->commit();

        return ['users' => $searchStmt->fetchAll(), 'numResults' => $countStmt->fetchColumn(0)];
    } catch (PDOException $exception) {
        $conn->rollBack();
        throw $exception;
    }

}



function getOrderedAllBannedUsers($offset, $limit)
{
    global $conn;

            $orderCriteria = '"expires"';
            $orderDirection = 'DESC';


    try {
        $conn->beginTransaction();
        $countStmt = $conn->prepare('SELECT Count(*) FROM "BannedUser"');
        $countStmt->execute();
        $searchStmt = $conn->prepare('SELECT "userId", "reason", "expires" FROM "BannedUser" ORDER BY ? LIMIT ? OFFSET ?');
        $searchStmt->execute(['"expires" DESC', $limit, $offset]);

        $conn->commit();

        return ['users' => $searchStmt->fetchAll(), 'numResults' => $countStmt->fetchColumn(0)];
    } catch (PDOException $exception) {
        $conn->rollBack();
        throw $exception;
    }

}

function getAllOrderedPendingTags($offset,$limit){
    global $conn;


    try {
        $conn->beginTransaction();
        $countStmt = $conn->prepare('SELECT Count(*) FROM "PendingTag"');
        $countStmt->execute();
        $searchStmt = $conn->prepare('SELECT "id","name" FROM "PendingTag" ORDER BY ? LIMIT ? OFFSET ?');
        $searchStmt->execute(['"id" DESC', $limit, $offset]);

        $conn->commit();

        return ['tags' => $searchStmt->fetchAll(), 'numResults' => $countStmt->fetchColumn(0)];
    } catch (PDOException $exception) {
        $conn->rollBack();
        throw $exception;
    }

}

function getAllBannedUsers()
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "BannedUser"');
    $stmt->execute();
    return $stmt->fetchAll();
}

function becomeAdmin($id)
{
    global $conn;
    $admin =3 ;
    $stmt = $conn->prepare('UPDATE "User" SET "privilegeLevelId" = ? WHERE "id" = ?');
    $stmt->execute([$admin, $id]);
}

function becomeModerator($id)
{
    global $conn;
    $moderator =2 ;
    $stmt = $conn->prepare('UPDATE "User" SET "privilegeLevelId" = ? WHERE "id" = ?');
    $stmt->execute([$moderator, $id]);
}






function getUserReplyRating($userId)
{
    global $conn;
    $stmt = $conn->prepare(
        'SELECT SUM("Content"."rating") FROM final."Content", final."Reply" WHERE "creatorId" = ? AND "contentId" = "Content".id');
    $stmt->execute([$userId]);
    return $stmt->fetch()['sum'];
}

function getUserQuestionRating($userId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT SUM("Content"."rating") FROM final."Content", final."Question" WHERE "creatorId" = ? AND "contentId" = "Content".id');
    $stmt->execute([$userId]);
    return $stmt->fetch()['sum'];
}

function userScore($userId)
{
    $question = getUserQuestionRating($userId);
	$reply = getUserReplyRating($userId);
    return $question + 3 * $reply;
}



