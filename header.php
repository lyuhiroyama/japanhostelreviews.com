
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

    .header-buttons {
        margin: 10px;
    }


</style>

<header>
    <div class="top-menu">
        <a href="index.php" style="color:white;"><img src="assets/header-logo.png" id="header-logo"></a>
        <div>
            <input id="search-box" type="text" placeholder="Search">
        </div>
        <a href="idk" class="header-buttons"><p>Create Account</p></a>

    </div>
</header>