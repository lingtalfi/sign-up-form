<?php


/*
* If you use QuickPdo, you need the two lines below, otherwise you don't.
*/
use QuickPdo\QuickPdo;
require_once "../init.php"; // adapt this line so that it can autoload QuickPdo


//--------------------------------------------
// CONFIG
//--------------------------------------------
$table = "users"; // in which table are we going to insert the newly created users

// in order to insert an user in database, we need to fill all the columns, what are they?
// (note: don't add auto-incremented fields, it's automatically handled)
// the format is key => value
// email and password will be automatically inserted by the script below
$userDefaults = [
    'active' => 1,
    'url_photo' => '',
    'name' => '',
    'last_name' => '',
    'gender' => 'm',
    'birthday_date' => null,
    'zip_code' => "",
    'website' => "",
];

// use this function if you need to decorate the array representing the user (which will
// be inserted in database)  based on the dynamically added email and/or password values
$userDefaultsAfter = function (array &$item) {
    $item['pseudo'] = explode('@', $item['email'])[0];
};


//--------------------------------------------
// SCRIPT -- you shouldn't have to type much below this line
//--------------------------------------------
$formValidated = false;
$errorStateEmailExists = "";
$errorStateEmailValid = "";
$errorStatePasswordValid = "";
$email = "";
$password = "";
if (
    isset($_POST['email']) &&
    isset($_POST['password'])
) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    //--------------------------------------------
    // VERIFYING USER DATA
    //--------------------------------------------
    $formHasError = false;
    $res = QuickPdo::fetch('select id from users where email=:email', [
        'email' => $email,
    ]);

    if (false !== $res) {
        $formHasError = true;
        $errorStateEmailExists = "activated";
    } else {
        if (false === strpos($email, '@')) {
            $formHasError = true;
            $errorStateEmailValid = "activated";
        }
    }

    if (strlen($password) < 1) {
        $formHasError = true;
        $errorStatePasswordValid = "activated";
    }

    //--------------------------------------------
    // INSERT THE USER IN DATABASE
    //--------------------------------------------
    if (false === $formHasError) {

        $items = array_replace($userDefaults, [
            'email' => $email,
            'password' => $password,
        ]);
        call_user_func_array($userDefaultsAfter, [&$items]);
        if (false !== ($res = QuickPdo::insert('users', $items))) {
            $formValidated = true;
        }
    }

}

?>

<?php if (false === $formValidated): ?>
    <h1 class="centered block">Inscription</h1>
    <div class="centered block">
        <form id="form-inscription" action="#posted" method="post" class="form inscription-form">
            <label>
                <span>Email</span> <input id="input-email" type="text" name="email"
                                          value="<?php echo htmlspecialchars($email); ?>">
            </label>
            <span class="error <?php echo $errorStateEmailValid; ?>" id="error-email">This is not a valid email</span>
            <span class="error <?php echo $errorStateEmailExists; ?>" id="error-email2">This email already exist in the database</span>
            <label>
                <span>Choisissez un mot de passe</span> <input id="input-password" type="password" name="password"
                                                               value="<?php echo htmlspecialchars($password); ?>">
            </label>
            <span class="error <?php echo $errorStatePasswordValid; ?>" id="error-password">Your password must contain at least 1 character</span>
            <div class="submit">
                <input id="input-submit" class="input-submit" type="submit" value="S'inscrire">
            </div>
        </form>
    </div>

    <script>
        var inputSubmit = document.getElementById('input-submit');


        function formValidate() {
            submitOk = true;

            var email = document.getElementById('input-email').value;
            var password = document.getElementById('input-password').value;
            var emailError = document.getElementById("error-email");
            var passwordError = document.getElementById("error-password");


            if (-1 === email.indexOf("@")) {
                emailError.classList.add("activated");
                submitOk = false;
            }
            else {
                emailError.classList.remove("activated");
            }

            if (password.length < 1) {
                passwordError.classList.add("activated");
                submitOk = false;
            }
            else {
                passwordError.classList.remove("activated");
            }

            return submitOk;
        }

        inputSubmit.addEventListener('click', function (e) {
            if (true || true === formValidate()) {
                document.getElementById("form-inscription").submit();
            }
            else {
                e.preventDefault();
            }
        });
    </script>
<?php else: ?>
    <p class="form-success centered block">
        Congratulations! You are now registered.<br>
        You can now sign in.<br>

    </p>
<?php endif; ?>



