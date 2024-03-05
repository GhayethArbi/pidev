const resultContainer = document.getElementById("result");
const searchBtn = document.getElementById("search-button");
const searchInput = document.getElementById("search-input");
const searchContainer = document.querySelector(".search-box");

// Api url to fetch meal data
const apiUrl = "https://www.themealdb.com/api/json/v1/1/search.php?s=";

// Event listeners for search and input (when press enter)
searchBtn.addEventListener("click", searchMeal);
searchInput.addEventListener("keydown", function (e) {
    if (e.keyCode === 13) {
        e.preventDefault();
        searchMeal();
    }
});

// Handle meal function
function searchMeal() {
    const userInput = searchInput.value.trim();
    if (!userInput) {
        resultContainer.innerHTML = `
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-danger me-1"></i>
        Input Field Cannot Be Empty        
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
        `;
        return;
    }
    // Fetch meal data using api with user input
    fetch(apiUrl + userInput).then((response) => response.json()).then((data) => {
        const meal = data.meals[0];
        // Handle where no meal found
        if (!meal) {
            resultContainer.innerHTML = `   <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-danger me-1"></i>
            No Meal Found, Please Try Again!    
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>`;
            return;
        }
        const ingredients = getIngredients(meal);
        // Generate Html to display meal data
        const recipeHtml = `
            <div class="card">
            <div class="card-body">
            <h5 class="card-title">${meal.strMeal}</h5>
                <h4 >${meal.strArea}</h4>
            </div>
            </div>
            <img src=${meal.strMealThumb} alt=${meal.strMeal} style=" display: block;
            width: 35%;
            margin: 28px auto 22px;
            border-radius: 6px;" />
            <div id="ingre-container">
                <h3>Ingredients:</h3>
                <ul>${ingredients}</ul>
            </div>
            <div id="recipe">
                <button id="hide-recipe" class="btn btn-outline-dark">X view less details</button>
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Recipe deatails</h4>
                <p class="mb-0">${meal.strInstructions}</p>
              </div>
            </div>
            <button id="show-recipe" class="btn btn-dark" >View Recipe</button>
        `;
        resultContainer.innerHTML = recipeHtml;

        const hideRecipeBtn = document.getElementById("hide-recipe");
        hideRecipeBtn.addEventListener("click", hideRecipe);
        const showRecipeBtn = document.getElementById("show-recipe");
        showRecipeBtn.addEventListener("click", showRecipe);
        searchContainer.style.opacity = '0';
        searchContainer.style.display = 'none';
    })
        // Handle error
        .catch(() => {
            searchContainer.style.opacity = '1';
            searchContainer.style.display = 'grid';
            resultContainer.innerHTML = `<h3>Error fetching data!</h3>`;
        });
}

// Generate html for list of ingredients
function getIngredients(meal) {
    let ingreHtml = "";
    // There can be maximum of 20 ingredients
    for (let i = 1; i <= 20; i++) {
        const ingredient = meal[`strIngredient${i}`];
        if (ingredient) {
            const measure = meal[`strMeasure${i}`];
            ingreHtml += `<li>${measure} ${ingredient}</li>`;
        }
        // If ingredient doesn't exist, exit loop
        else {
            break;
        }
    }
    return ingreHtml;
}

// Handle show and hide recipe for a meal
function hideRecipe() {
    const recipe = document.getElementById("recipe");
    recipe.style.display = "none";
}
function showRecipe() {
    const recipe = document.getElementById("recipe");
    recipe.style.display = "block";
}