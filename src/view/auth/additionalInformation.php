<?php 
    require_once(__DIR__ ."/../../controllers/auth/additionalInfoController.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(__DIR__ . "/../component/header.php");
    ?>
    <link rel="stylesheet" href="/assets/styles/additionalInfo.css">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
    <!-- Additional Information Modal -->
    <div class="modal active">
        <div class="modal-content">
            <h3 class="modal-title">Complete Your Profile</h3>
            <form id="additionalInfoForm" class="form-layout" method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data">
                <div class="profile-section">
                    <div class="profile-picture" id="profilePictureContainer">
                        <img src="/assets/img/home/default_profile.png" alt="Profile Picture" id="profilePicturePreview">
                    </div>
                    <div class="profile-image-upload">
                        <input type="file" id="profile-image" name="profile_image" accept="image/*">
                        <label for="profile-image">
                            <i class="fas fa-upload"></i> Change Picture
                        </label>
                    </div>
                </div>
                <div class="fields-section">

                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        <input type="date" id="birthday" name="birthday" Required>
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <div class="radio-group" >
                            <label>
                                <input type="radio" name="gender" value="male" Required> Male
                            </label>
                            <label>
                                <input type="radio" name="gender" value="female" Required> Female
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bio">About Me</label>
                        <textarea id="bio" name="bio" rows="4" placeholder="Write a short bio (optional)"></textarea>
                    </div>
                </div>
                <button type="submit" class="save-button">Save</button>
            </form>
        </div>
    </div>
    </div>


</body>

</html>