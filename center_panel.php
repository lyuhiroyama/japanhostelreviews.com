

<head>
    <style>
        .center-panel {
            flex-grow: 1; /* Not exactly sure how this works, but it fills up the centre of viewport dynamically */
            margin-left: 270px;
            height: 100%;
        }

        .hostel-container {
            height: 130px;
            margin: 20px;
        }

        .hostel {
            display: flex;
        }

        .hostel-info { /* container with info excluding thumbnail */
            padding: 20px;
        }
        

        .thumbnail {
            width: 200px;
            height: 120px;
            object-fit: contain; /* Fills content box while maintaining aspect ratio */
        }

        h3.hostel-title a:visited {
            color: grey;
        }
    </style>
</head>

<body>
    <div class="center-panel"></div>
    <script>
        // Fetch & Dipslay hostels
        function fetchHostels() {
            $.getJSON('get_hostels.php', function(hostels) {
                hostels.forEach(hostel => {
                    $('.center-panel').append(`
                        <div class="hostel-container">

                                <div class="hostel">
                                    <a href="hostel_details.php?id=${hostel.id}">
                                        <img src="${hostel.thumbnail}" class="thumbnail">
                                    </a>
                                    <div class="hostel-info">
                                        <h3 class="hostel-title">
                                            <a href="hostel_details.php?id=${hostel.id}">
                                            ${hostel.name}
                                            </a>
                                        </h3>
                                        <p>${hostel.description}</p>
                                        <p>Location: ${hostel.location}</p>
                                        <p>Price Range: ${hostel.price_range}</p>
                                        <div class="voting-container">
                                            <button class="upvote" data-id="${hostel.id}">⬆️</button>
                                            <span class="vote-count">${hostel.upvote - hostel.downvote}</span>
                                            <button class="downvote" data-id="${hostel.id}">⬇️</button>
                                        </div>

                                    </div>
                                </div>

                        </div>
                        <hr>
                    `)
                })
            
                // Handle upvlote/downvote clicks:
                $('.upvote').click( function() {
                    const hostelId = $(this).data('id');
                    let bool = trackHostelVote(hostelId, 'upvote');
                    if (bool) {updateVote(hostelId, 'upvote')};
                });
                $('.downvote').click( function() {
                    const hostelId = $(this).data('id');
                    let bool = trackHostelVote(hostelId, 'downvote');
                    if (bool) {updateVote(hostelId, 'downvote')};
                });
            
            })
        } // endof fetchHostels()

        function updateVote(hostelId, voteType) {
            $.post('update_hostel_votes.php', {id: hostelId, vote: voteType}, () => {
                $('.center-panel').empty();
                fetchHostels();
            })
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


        $(document).ready(fetchHostels);
        
    </script>
</body>