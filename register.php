<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="public/styles.css">

</head>

<body>

    <section class="form-container">
        <div class="alert-danger" style="display: none;"></div>
        <form>
            <h3>Register</h3>
            <p>Name<span>*</span></p>
            <input id="name" type="text" name="name" placeholder="enter your name" required maxlength="50" class="box">
            <p>Email<span>*</span></p>
            <input id="email" type="email" name="email" placeholder="enter your email" required maxlength="50" class="box">
            <p>Password<span>*</span></p>
            <input id="password" type="password" name="pass" placeholder="enter your password" required maxlength="20" class="box">
            <p>Date of Birth<span>*</span></p>
            <input id="dob" type="date" name="dob" required class="box">
            <button onclick="validateForm()" class="btn">Register</button>
            <center>
                <p>Already have an account? <a href="login.php">Login Now</a></p>
            </center>
        </form>


    </section>
    <script>
        const validateForm = () => {
            const form = document.querySelector('form');
            const name = document.querySelector('#name').value;
            const email = document.querySelector('#email').value;
            const pass = document.querySelector('#password').value;
            const dob = document.querySelector('#dob').value;
            const error = document.querySelector('.alert-danger');

            console.log(name, email, pass, dob);


            if (!name || !email || !pass || !dob || !error) {
                error.innerHTML = 'All fields are required';
                error.style.display = 'block';
                return;
            }
            if (pass.length < 6) {
                error.innerHTML = 'Password must be atleast 6 characters long';
                error.style.display = 'block';
                return;
            }
            const regex = /^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/;
            if (!regex.test(email)) {
                error.innerHTML = 'Invalid email';
                error.style.display = 'block';
                return;
            }
            form.method = 'post';
            form.action = 'register_action.php';
            form.submit();
        }
    </script>


</body>

</html>