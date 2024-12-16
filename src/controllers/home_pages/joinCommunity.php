<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once __DIR__ . "/../../model/userModel.php";
require_once __DIR__ . "/../../model/communitiesModel.php";
session_start();

header('Content-Type: application/json');

try {
    if (isset($_POST["community_id"]) && isset($_POST["user_id"])) {
        $user_id = $_POST["user_id"];
        $community_id = $_POST["community_id"];
        if ($user_id == $_SESSION["user_id"]) {
            if (isCommunityOpen($community_id)) {
                if (isUserInCommunity($user_id, $community_id)) {
                    throw new Exception("user is already in community");
                } else {
                    if (joinCommunity($user_id, $community_id)) {
                        echo json_encode([
                            "success" => true,
                            "message" => 'Joind the Community Successfully',
                            "community_id" => $community_id
                        ]);
                    } else {
                        throw new Exception("Error joining community");
                    }
                }
            } else {
                throw new Exception("community is close or not found");
            }
        } else {
            throw new Exception("unauthorized accsess");
        }
    } else {
        throw new Exception("ids are not set");
    }
} catch (Exception $e) {
    error_log("Error Joining Community :" . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
    exit();
}
