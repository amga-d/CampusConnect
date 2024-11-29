function toggleReadMore(element) {
    const excerpt = element.previousElementSibling;
    const isCollapsed = excerpt.style.webkitLineClamp === "3" || !excerpt.style.webkitLineClamp;

    if (isCollapsed) {
        excerpt.style.display = "block";
        excerpt.style.webkitLineClamp = "unset";
        element.textContent = "Read less";
    } else {
        excerpt.style.webkitLineClamp = "3";
        excerpt.style.display = "-webkit-box";
        element.textContent = "Read more";
    }
}