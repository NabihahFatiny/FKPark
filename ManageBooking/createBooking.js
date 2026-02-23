document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('DOMContentLoaded', function() {
        var tabButtons = document.querySelectorAll('.tab-button');
        tabButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var sectionId = this.getAttribute('data-section');
                showTab(sectionId, this);
            });
        });
    });
    
    
    // Function to handle tab switching
    function showTab(sectionId, element) {
        var tabs = document.querySelectorAll('.tab-button');
        var contents = document.querySelectorAll('.tab-content');
        var indicator = document.querySelector('.tab-indicator');

        tabs.forEach(function(tab) {
            tab.classList.remove('tab-active');
        });

        contents.forEach(function(content) {
            content.classList.remove('active');
        });

        var activeContent = document.querySelector(`#${sectionId}`);
        activeContent.classList.add('active');
        element.classList.add('tab-active');

        indicator.style.left = element.offsetLeft + 'px';
        indicator.style.width = element.offsetWidth + 'px';
    }

    // Add event listeners to the tab buttons
    var tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var sectionId = this.getAttribute('data-section');
            showTab(sectionId, this);
        });
    });

    // Initial tab setup
    var activeTabButton = document.querySelector('.tab-button.tab-active');
    if (activeTabButton) {
        var sectionId = activeTabButton.getAttribute('data-section');
        showTab(sectionId, activeTabButton);
    }

    // Add event listener to handle book link clicks
    var bookingContainer = document.querySelector('.create-booking');
    bookingContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('book-link')) {
            event.preventDefault();
            var parkingSpot = event.target.closest('tr').querySelector('td').textContent;
            window.location.href = 'confirmBooking.php?parkingSpot=' + encodeURIComponent(parkingSpot);

        }
    });

    document.getElementById('show-vacant-btn').addEventListener('click', function() {
        var today = new Date().toISOString().slice(0, 10); // Format today's date as YYYY-MM-DD
        var sections = ['sectionA', 'sectionB', 'sectionC', 'sectionD'];

        sections.forEach(function(section) {
            var table = document.getElementById(section).querySelector('table');
            fetchVacantSpots(table, section.charAt(section.length - 1), today);
        });
    });
});

function fetchVacantSpots(table, section, date) {
    // Send an AJAX request to the server to get vacant spots
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'getVacantSpots.php?section=' + section + '&date=' + date, true);
    xhr.onload = function() {
        if (this.status == 200) {
            var spots = JSON.parse(this.responseText);
            var rows = '';
            spots.forEach(function(spot) {
                rows += '<tr data-available="true">';
                rows += '<td>' + spot.parkingSlot_name + '</td>';
                rows += '<td><a href="confirmBooking.php?parkingSpot=' + spot.parkingSlot_name + '" class="book-link">Book</a></td>';
                rows += '</tr>';
            });
            table.innerHTML = rows;
        }
    };
    xhr.send();
}

