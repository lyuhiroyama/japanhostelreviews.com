
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
    }
    

    #header-logo {
        height: 100px;
        width: auto;
        margin: 0 10px 0;
    }


    #search-box {
        background-color: #f0f0f0; 
        border-radius: 25px; 
        border: 1px solid #bababa;
        padding: 10px 20px;
        width: 400px; 
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
    }

    .sign-in-up-buttons-container .sign-in-up-buttons:hover {
        background-color: #e6deca;
    }

    .sign-in-up-buttons + .sign-in-up-buttons { 
        /* + is an adjacent sibling selector. Targets the second button, hence border-LEFT: */
        border-left: 1px solid black;
    }

</style>

<header>
    <div class="top-menu">
        <a href="index.php" style="color:white;"><img src="assets/header-logo.png" id="header-logo"></a>
        <div>
            <input id="search-box" type="text" placeholder="Search">
        </div>
        <div class="sign-in-up-buttons-container">
            <a href="idk yet" class="sign-in-up-buttons">Sign in</a>
            <a href="idk yet" class="sign-in-up-buttons">Sign up</a>
        </div>




    </div>
</header>