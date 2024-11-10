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

        #sign-up-modal {
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

        #sign-up-modal h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        #sign-up-modal .sign-up-modal-subheading {
            margin-bottom: 40px;
        }

        #sign-up-modal form {
            display: none;
            flex-direction: column;
            gap: 15px;
        }

        #sign-up-modal form input {
            background-color: #e5ebee; 
            border-radius: 4px; 
            border: 1px solid transparent;
            padding: 10px 20px;            
            font-size: 16px;
        }

        #sign-up-modal form #sign-up-submit-button {
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

        #sign-up-modal form #sign-up-submit-button:hover {
            background-color: #ffb366;
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

    <div id="sign-up-modal">
        <span class="close-modal">&times;</span>
        <h2>Ready to add a review?</h2>
        <p class="sign-up-modal-subheading">No password required. We'll email you a link to sign in with!</p>
        <form autocomplete="off">
            <label>Username *</label>
            <input type="text" name="username" id="username">
            <label>Email *</label>
            <input type="email" name="email" id="email">
            <button id="sign-up-submit-button" type="submit">Sign up</button>
        </form>
    </div>
</body>

<script>
    $(document).ready(function() {
        $('#sign-up-button').on('click', function() {
            $('#sign-up-modal').fadeIn();
            $('#sign-up-modal form').css('display', 'flex');
        });

        $('.close-modal').on('click', function() {
            $('#sign-up-modal').hide();
        })
    });
</script>