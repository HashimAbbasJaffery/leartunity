function calculateReviewStars(rating) {
    let markup = "";
    const total = 5;
    const stars = Math.floor(rating);
    const halfStar = rating - stars;
    let remainingStars = total - stars;

    if (rating <= 5 && rating !== 0) {
        for (let i = 0; i < stars; i++) {
            markup += '<i class="fa-solid fa-star"></i>';
        }
        if (halfStar >= 0.5) {
            markup += '<i class="fa-solid fa-star-half-stroke"></i>';
        }
        for (let i = 0; i < remainingStars; i++) {
            markup += '<i class="fa-regular fa-star"></i>';
        }
    } else {
        markup += '<p>No rating yet!</p>';
    }

    return markup;
}

export default calculateReviewStars;