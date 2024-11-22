// API URL
const apiUrl = 'http://localhost:8000/web_streaming/api/anime';  // Sesuaikan dengan URL backend Anda

// Elemen HTML
const animeListContainer = document.getElementById('anime-list-container');
const addAnimeBtn = document.getElementById('add-anime-btn');
const animeFormContainer = document.getElementById('anime-form-container');
const animeForm = document.getElementById('anime-form');
const submitBtn = document.getElementById('submit-btn');

// Form input elements
const animeIdInput = document.getElementById('anime-id');
const animeTitleInput = document.getElementById('anime-title');
const animeGenreInput = document.getElementById('anime-genre');
const animeDescriptionInput = document.getElementById('anime-description');
const animeReleaseYearInput = document.getElementById('anime-release-year');


addAnimeBtn.addEventListener('click', () => {
    animeFormContainer.style.display = 'block';
    submitBtn.innerText = 'Add Anime';
    clearForm();
});

// Handle form submission
animeForm.addEventListener('submit', (e) => {
    e.preventDefault();  // Prevent page refresh on form submit
    
    const title = animeTitleInput.value;
    const genre = animeGenreInput.value;
    const description = animeDescriptionInput.value;
    const releaseYear = animeReleaseYearInput.value;
    const id = animeIdInput.value;

    if (id) {
        // If there is an ID, update anime
        updateAnime(id, title, genre, description, releaseYear);
    } else {
        // Otherwise, add new anime
        addAnime(title, genre, description, releaseYear);
    }

    animeFormContainer.style.display = 'none';  
    fetchAllAnime();  // Reload the anime list
});


function addAnime(title, genre, description, releaseYear) {
    const data = {
        title: title,
        genre: genre,
        description: description,
        release_year: releaseYear
    };

    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'  
        },
        body: JSON.stringify(data),  // Mengirim data sebagai JSON
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Anime added successfully!');
            fetchAllAnime(); 
        } else {
            alert('Failed to add anime');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


// Update an existing anime
function updateAnime(id, title, genre, description, releaseYear) {
    const data = { title, genre, description, release_year: releaseYear };

    fetch(`${apiUrl}/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),  // Send updated data as JSON
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Anime updated successfully!');
        } else {
            alert('Failed to update anime');
        }
    })
    .catch(error => console.error('Error:', error));
}

// Delete an anime from the database
function deleteAnime(id) {
    fetch(`${apiUrl}/${id}`, {
        method: 'DELETE',
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Anime deleted successfully!');
            fetchAllAnime();  // Reload the anime list after deletion
        } else {
            alert('Failed to delete anime');
        }
    })
    .catch(error => console.error('Error:', error));
}

// Fetch all anime from the database
function fetchAllAnime() {
    fetch(apiUrl)  // GET request to fetch all anime
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                displayAnimeList(data.data); // Display anime in table
            } else {
                alert('No anime found');
            }
        })
        .catch(error => console.error('Error fetching anime list:', error));
}

// Display anime list in the table
function displayAnimeList(animeList) {
    animeListContainer.innerHTML = '';  // Clear previous list
    animeList.forEach(anime => {
        const animeRow = document.createElement('tr');
        animeRow.innerHTML = `
            <td>${anime.title}</td>
            <td>${anime.genre}</td>
            <td>${anime.description}</td>
            <td>${anime.release_year}</td>
            <td>
                <button onclick="editAnime(${anime.id})">Edit</button>
                <button onclick="deleteAnime(${anime.id})">Delete</button>
            </td>
        `;
        animeListContainer.appendChild(animeRow);  // Append row to table
    });
}

// Edit anime data in the form
function editAnime(id) {
    fetch(`${apiUrl}/${id}`)  // GET request to fetch anime by ID
        .then(response => response.json())
        .then(data => {
            const anime = data.data;
            animeIdInput.value = anime.id;
            animeTitleInput.value = anime.title;
            animeGenreInput.value = anime.genre;
            animeDescriptionInput.value = anime.description;
            animeReleaseYearInput.value = anime.release_year;
            submitBtn.innerText = 'Update Anime';  
            animeFormContainer.style.display = 'block';  // Show the form
        });
}

// Clear the form inputs
function clearForm() {
    animeIdInput.value = '';
    animeTitleInput.value = '';
    animeGenreInput.value = '';
    animeDescriptionInput.value = '';
    animeReleaseYearInput.value = '';
}

// Initialize and fetch all anime on page load
window.onload = fetchAllAnime;
