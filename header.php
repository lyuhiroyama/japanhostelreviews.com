<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .top-menu {
            display: flex;
            justify-content: space-between;
            align-items:center;
            position: fixed;
            top: 0;
            width: 100%;
            height: 60px;
            background-color: #ffffff;
            border: 1px solid #bababa;
            color: white;
            text-align: center;
            z-index: 100; /* To keep header beneath the modal */
        }
        

        #header-logo {
            height: 100px;
            width: auto;
            margin: 0 10px 0;
        }


        #search-box {
            background-color: #e5ebee; 
            border-radius: 25px; 
            border: 1px solid transparent;
            padding: 10px 20px;
            height:40px;
            width: 400px; 
            font-size: 16px;
        }

        .sign-in-up-buttons-container {
            display: flex;
            border: 1px solid black;
            border-radius: 20px;
            margin-right: 10px;
            overflow: hidden; /* incase letters go over the border */
            background-color: #faf8f2;
        }

        .sign-in-up-buttons-container .sign-in-up-buttons {
            padding: 10px 20px;
            color: black;
        }

        .sign-in-up-buttons-container .sign-in-up-buttons:hover {
            background-color: #e6deca;
            cursor: pointer;
        }

        .sign-in-up-buttons + .sign-in-up-buttons { 
            /* + is an adjacent sibling selector. Targets the second button, hence border-LEFT: */
            border-left: 1px solid black;
        }

        /* Modals: */

        .close-modal {
            position: absolute;
            color: #666;
            top: 15px;
            right: 20px;
            font-size: 35px;
        }

        .close-modal:hover {
            color: #333;
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed; /* Needed for z-index to work */
            z-index: 1000;
            background-color: white;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); 
            /* ⬆️ Additional offset. 'top' and 'left' did not suffice. */
            padding: 50px;
            border: 1px solid black;
            border-radius: 20px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
        }

        .modal h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .modal .sign-in-up-modal-subheading {
            margin-bottom: 40px;
        }

        .modal form {
            display: none;
            flex-direction: column;
            gap: 15px;
        }

        .modal form input {
            background-color: #e5ebee; 
            border-radius: 4px; 
            border: 1px solid transparent;
            padding: 10px 20px;
            margin-bottom: 10px;        
            font-size: 16px;
        }

        .modal form .sign-in-up-submit-button {
            background-color: #e7dfc9;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            width: 60%;
            cursor: pointer;
            margin: 10px auto 0;
            font-size: 16px;
            font-weight: bold;
            color: #262524; /* less black than black */
        }

        .modal form .sign-in-up-submit-button:hover {
            background-color: #ffb366;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        @media screen and (max-width: 768px) {
            #search-box {
                width: 150px;
            }
            
            #sign-in-up-buttons-container {
                width: 150px;
                margin: 0 10px;
            }

            .sign-in-up-buttons-container .sign-in-up-buttons {
                padding: 10px 10px;
                color: black;
            }
        }

        @media screen and (max-width: 480px) { /* For mobile devices in portrait mode. */
            
            .sign-in-up-buttons-container {
                border: none; /* a black dot remains otherwise. */
            }
            
            .sign-in-up-buttons {
                display: none;
            }
        }

    </style>
</head>
<body>
    <header>
        <div class="top-menu">
            <a href="index.php" style="color:white;"><img src="assets/header-logo.png" id="header-logo"></a>
            <div>
                <input id="search-box" type="text" placeholder="Search hostels here!">
            </div>
            <div class="sign-in-up-buttons-container">
                <div class="sign-in-up-buttons" id="sign-in-button">Sign in</div>
                <div class="sign-in-up-buttons" id="sign-up-button">Sign up</div>
            </div>
        </div>
    </header>

    <div class="modal" id="sign-up-modal">
        <span class="close-modal">&times;</span>
        <h2>Ready to add a review?</h2>
        <p class="sign-in-up-modal-subheading">No password required. We'll email you a link to sign in with!</p>
        <form autocomplete="off">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <input type="email" name="email" id="email" placeholder="review@email.com" required>
            <button class="sign-in-up-submit-button" type="submit">Sign up</button>
        </form>
    </div>

    <div class="modal" id="sign-in-modal">
        <span class="close-modal">&times;</span>
        <h2>Welcome back!</h2>
        <p class="sign-in-up-modal-subheading">No password required. We'll email you a link to sign in with!</p>
        <form autocomplete="off">
            <input type="email" name="email" id="email" placeholder="review@email.com" required>
            <button class="sign-in-up-submit-button" type="submit">Sign in</button>
        </form>
    </div>

    <div class="modal-overlay"></div>
</body>

<script>
    $(document).ready(function() {
        $('#sign-up-button').on('click', function() {
            $('.modal').hide();
            $('.modal-overlay').fadeIn();
            $('#sign-up-modal').fadeIn();
            $('#sign-up-modal form').css('display', 'flex');
        });

        $('#sign-in-button').on('click', function() {
            $('.modal').hide();
            $('.modal-overlay').fadeIn();
            $('#sign-in-modal').fadeIn();
            $('#sign-in-modal form').css('display', 'flex');
        });

        $('.modal form').on('submit', function(e) {
            e.preventDefault();
            alert("Sent! Check your inbox for the log in link. If you don't see it, check your spam box too!");
        });

        $('.close-modal').on('click', function() {
            $('.modal').fadeOut();
            $('.modal-overlay').fadeOut();
        });

        $('.modal-overlay').on('click', function() {
            $('.modal').fadeOut();
            $('.modal-overlay').fadeOut();
        });
    });
</script>