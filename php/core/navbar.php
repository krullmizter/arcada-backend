<nav class='navbar'>
    <div class='navbar__logo navbar__col'>
        <a href='../frontpage'><h1>ReadIt</h1></a>
    </div>

    <form method='GET' class='navbar__search navbar__col'>
        <input type='search' id="navbar__searchField" name='navbar__searchField' placeholder='Search ReadIt'>
        <button type='submit' class="btn-reverse">Search</button>
    </form>

    <div class='navbar__account navbar__col'>
        <?php 
            if(isset($_SESSION['loggedin'])) {
                echo '
                <a href="../../pages/profile"> 
                    <button><i class="fas fa-user"></i> '.$_SESSION['username'].'</button> 
                </a>

                <a href="../../php/includes/account/logout.php"> 
                    <button>Logout <i class="fas fa-sign-out-alt"></i></button> 
                </a>';
                
                if($_SESSION['role'] == 'admin') {
                    echo '<a href="../../pages/admin">
                        <button><i class="fas fa-user-shield"></i> Admin</button> 
                    </a>';
                }
            } else {
                echo '
                <button id="navbar__loginBtn"><i class="fas fa-sign-in-alt"></i> Login</button> 
                <button id="navbar__signupBtn"><i class="fas fa-user-plus"></i> Signup</button>';
            }
        ?>
        
        <a href='../../pages/report'>
            <button><i class='fas fa-scroll'></i> Report</button> 
        </a>

        <div class="overlay-login">
            <form method='post' action='../../php/includes/account/login.php' id='navbar__login'>
                <h5>Login</h5>
                <input type='text' name='loginUsername' placeholder="Username" required>
                <input type='password' name='loginPass' placeholder="Password" required>
                <input type='submit' value='Login' class='btn'>
                <button type="button" class="navbar__login-close">Close</button>
            </form>
        </div>

        <div class="overlay-signup">
            <form method='post' action='../../php/includes/account/signup.php' id='navbar__signup'>
                <h5>Signup</h5>
                <input type='text' name='signupName' placeholder="Name *" required>
                <input type='text' name='signUpUsername' placeholder="Username *" required>
                <input type='email' name='signupEmail' placeholder="Email *" required>
                <input type='password' name='signupPass' id='signupPass' placeholder="Password *" required>
                <p>2 uppercase characters and min. 8 length</p>
                <input type='submit' value='Sign Up' class='btn'>
                <button type="button" class="navbar__signup-close">Close</button>
            </form>
        </div>
    </div>
</nav>