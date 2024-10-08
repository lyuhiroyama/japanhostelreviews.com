
<head>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"> <!-- import Google Material Icons -->
    <style>
        
        .left-panel {
            position: fixed;
            top: 65px;
            height: 100%;
            width: 270px; 
            background-color: #ffffff; 
            border-right: 1px solid #ccc; 
        }
        
        .left-panel ul li {
            margin: 10px 26px;
            padding: 10px;
            list-style-type: none;
        }

        .li-buttons:hover {
            background-color: #f5f5f5;
            border-radius: 10px;
        }

        .left-panel ul li a {
            display: flex;
            align-items: center;
        }

        .material-symbols-outlined { /* the icons */
            margin-bottom: 5px;
            margin-left: -5px;
            margin-right: 3px;
            padding-left: 5px;
        }







        
        
    </style>
</head>

<div class="left-panel">
    <ul>
        <li class="li-buttons"><a href="index.php"><span class="material-symbols-outlined">home</span>Home</a></li>
        <hr>
        <li class="li-headers">Recent</li>
    </ul>
</div>
