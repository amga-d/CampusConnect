const bar = document.getElementById("bar");
const navbar = document.getElementById("navbar");
const closebutton = document.getElementById("close");


if (bar) {
    bar.addEventListener("click", () => {
        navbar.classList.add("active");
    });
}
if (closebutton){
    closebutton.addEventListener("click", () =>{
        navbar.classList.remove("active");
    })
}


initializeProducts(6);
initializefeatureBoxes();

function initializeProducts(n) {
    let productsContainer = document.getElementsByClassName("prod-container");
    let product = `
                <div class="des">
                    <span>Adidas</span>
                    <h5>Cartoon Astronaut T-Shirts</h5>
                    <div class="stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h4 class="price"></h4>
                </div>
                <a href="#"><i class="bi bi-cart3"></i></a>`;

    for (let i = 1; i <= n; i++) {
        let prodBox = document.createElement("div");
        let imgElement = document.createElement("img");
        prodBox.className = "prod";
        prodBox.innerHTML = product;
        imgElement.src = `./assets/img/products/f${i}.jpg`;
        prodBox.insertAdjacentElement("afterbegin", imgElement);
        prodBox.getElementsByClassName("price")[0].textContent = `${i}   Rp`;
        productsContainer[0].insertAdjacentElement("beforeend", prodBox);
    }
}

function initializefeatureBoxes() {
    let featurebox = document.getElementsByClassName("fe-box");
    for (let i = 0; i < featurebox.length; i++) {
        let featureImage = document.createElement("img");
        featureImage.setAttribute("src", `./assets/img/features/f${i+1}.png`);
        featurebox[i].insertBefore(featureImage, featurebox[i].firstChild);
    }
}

function setProfileMenu(){
    const menu = document.getElementById("profile-menu");
    menu.style.display = "block" ;
}
