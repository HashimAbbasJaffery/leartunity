const stars = document.querySelectorAll(".feedback-star")

const mouseoverStar = element => {
    element.addEventListener("mouseover", function() {
        const starSeries = element.dataset.star;
        for(let i = 5; i > 0; i--) {
            const star = document.querySelector(`.feedback-star[data-star='${i}']`);
            if(i > starSeries) {
                star.classList.remove("fa-solid");
                star.classList.add("fa-regular");
                star.classList.remove("starred");
            } else {
                star.classList.add("starred")
                star.classList.add("fa-solid");
                star.classList.remove("fa-regular");
            }
        }
    })
}

const mouseoutStar = (stars, old_class, new_class) => {
    stars.forEach(star => {
        star.classList.add(new_class);
        star.classList.remove(old_class);
    })
}

stars.forEach(star => {
    let flag = false;
    
    star.addEventListener("click", function() {
        if(!flag)
            mouseoverStar(star)
        flag = true;
    })

    if(!flag)
        mouseoverStar(star);
    
})