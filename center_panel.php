

<head>
    <style>
        .center-panel {
            flex-grow: 1; /* Not exactly sure how this works, but it fills up the centre of viewport dynamically */
            margin-left: 270px;
        }

        .hostel-container {
            height: 130px;
            margin: 20px;
        }

        .hostel {
            display: flex;
        }

        .hostel-info { /* container with info excluding thumbnail */
            padding: 0 10px;
            line-height: 1.5;
        }
        

        .thumbnail {
            width: 200px;
            height: 120px;
            object-fit: contain; /* Fills content box while maintaining aspect ratio */
        }

        h3.hostel-title a:visited {
            color: grey;
        }

        .hostel-voting-container {
            margin: 10px 0;
            width: auto; /* Adjusts width to fit its contents dynamically */
            border-radius: 50px;
            background-color: #e6deca;
            display: inline-flex;
            align-items: center;
        }

        .hostel-voting-container.relocation-768px { /* Made visible with media queries */
            display: none;
        }

        .hostel-voting-container button {
            color: #a3780d;
            font-size: 20px;
            border: none;
            background-color: transparent;
            width: 30px;
            height: 30px;
            cursor: pointer;
        }

        .hostel-voting-container button:hover {
            color: #ff0000;
            background-color: #f3e7ca;
            border-radius: 50px;
        }

        .hostel-voting-container span {
            margin: 0 5px; /* Spacing */
            font-size: 16px;
        }

        .hostel-voting-container button.active-upvote {
            color: red;
            background-color: #f3e7ca;
            border-radius: 10px;
        }

        .hostel-voting-container button.active-downvote {
            color: blue;
            background-color: #f3e7ca;
            border-radius: 10px;
        }

        @media screen and (max-width: 768px) {
            .center-panel {
                margin-left: 0px;
            }

            .hostel-thumbnail-container {
                margin-top: 10px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            
            .thumbnail {
                width: 125px;
                height: 75px;
                object-fit: contain; /* Fills content box while maintaining aspect ratio */
            }

            .hostel-voting-container.main { /* Hide voting container from main location */
                display: none;
            }

            .hostel-voting-container.relocation-768px { /* Make visible underneath thumbnail */
                display: inline-flex;
                width: fit-content;
            }

            h3.hostel-title {
                font-size: 17px;
            }

            .hostel-info {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="center-panel"></div>
    <script>

        $(document).ready(function() {
            fetchHostels(); // Initial fetch

            $('#search-box').on('input', function() {
                const query = $(this).val();
                fetchHostels(query);
            })
        })

        // Fetch & Dipslay hostels
        function fetchHostels(query = '') {
            $.getJSON('get_hostels.php', {q: query}, function(hostels) {
                $('.center-panel').empty(); // Clear previous results
                
                hostels.forEach(hostel => {
                    // Check localStorage for this hostel's vote
                    const voteKey = `hostelVote_${hostel.id}`;
                    const userVote = localStorage.getItem(voteKey);
                    
                    const upvoteClass = userVote === 'upvote' ? 'active-upvote' : '';
                    const downvoteClass = userVote === 'downvote' ? 'active-downvote' : '';

                    $('.center-panel').append(`
                        <div class="hostel-container" data-id="${hostel.id}">
                            <div class="hostel">
                                <a class="hostel-thumbnail-container" href="hostel_details.php?id=${hostel.id}">
                                    <img src="${hostel.thumbnail}" class="thumbnail">
                                    <div class="hostel-voting-container relocation-768px"> 
                                        <button class="upvote ${upvoteClass}" data-id="${hostel.id}">⬆</button>
                                        <span class="vote-count">${hostel.upvote - hostel.downvote}</span>
                                        <button class="downvote ${downvoteClass}" data-id="${hostel.id}">⬇</button>
                                    </div>
                                </a>
                                <div class="hostel-info">
                                    <h3 class="hostel-title">
                                        <a href="hostel_details.php?id=${hostel.id}">
                                        ${hostel.name}
                                        </a>
                                    </h3>
                                    <p>Location: ${hostel.location}</p>
                                    <p>Price Range: ${hostel.price_range}</p>
                                    <div class="hostel-voting-container main">
                                        <button class="upvote ${upvoteClass}" data-id="${hostel.id}">⬆</button>
                                        <span class="vote-count">${hostel.upvote - hostel.downvote}</span>
                                        <button class="downvote ${downvoteClass}" data-id="${hostel.id}">⬇</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    `)
                })
            
                // Handle upvote/downvote clicks:
                $('.upvote').click(function() {
                    const hostelId = $(this).data('id');
                    let bool = trackHostelVote(hostelId, 'upvote');
                    if (bool) {
                        updateVote(hostelId, 'upvote');
                        $(this).addClass('active-upvote');
                    }
                });
                $('.downvote').click(function() {
                    const hostelId = $(this).data('id');
                    let bool = trackHostelVote(hostelId, 'downvote');
                    if (bool) {
                        updateVote(hostelId, 'downvote');
                        $(this).addClass('active-downvote');
                    }
                });
            })
        } // endof fetchHostels()

        function updateVote(hostelId, voteType) {
            $.post('update_hostel_votes.php', {id: hostelId, vote: voteType}, function(response) {
                /*
                For debugging:
                console.log('Response:', response, 
                            'Container found:', $(`.hostel-container[data-id="${hostelId}"]`).length > 0,
                            'Vote span found:', $(`.hostel-container[data-id="${hostelId}"]`).find('.vote-count').length > 0);
                */
                const hostelContainer = $(`.hostel-container[data-id="${hostelId}"]`);
                const voteCountSpan = hostelContainer.find('.vote-count');
                voteCountSpan.text(response.newVoteCount);
            }, 'json')
            // .fail(function(jqXHR, textStatus, errorThrown) {  // Add error handling
            //     console.log('AJAX Error:', textStatus, errorThrown);
            // });
        } // endof updateVote()

        function trackHostelVote(hostelId, voteType) {
            let voteKey = `hostelVote_${hostelId}`;
            let existingVote = localStorage.getItem(voteKey);
            
            if (!existingVote) {
                localStorage.setItem(voteKey, voteType);
                return true;
            } else {
                return false;
            }
        } // endof trackHostelVote()
        
    </script>
</body>