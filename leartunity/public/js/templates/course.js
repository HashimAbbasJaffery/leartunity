import calculateReviewStars from "../helpers/stars.js";
const course = data => {
    const 
    { 
        author, 
        title,
        description,
        price,
        is_purchased,
        slug,
        stripe_id
     } = data;
    const { name } = author;
    const { reviews } = data;
    const { stars } = data;
    // {!! substr($description, 0, 80) !!}...
    return `
    <div class="course">
    <div class="course-header">
        <img src="https://placehold.co/600x400" alt="">
    </div>
    <div class="course-instructor mt-4 flex">
        <div class="instructor-img">
            <img src="https://placehold.co/45x45" class="rounded-full" alt="">
        </div>
        <div class="instructor-details flex">
            <h2>${name}</h2>
            <div class="course-rating flex">
                ${ calculateReviewStars(stars ?? 0) }
            </div>
        </div>
    </div>

    <div class="course-detail mt-4">
        <div class="course-description">
            <h1 style="font-size: 15px;">
                ${title}
            </h1>
            ${description.substr(0, 80)}...
        </div>
        <div class="course-options mt-2">
            ${ ( !is_purchased )
                ? 
                    '<a href="checkout/' + stripe_id + '">enroll</a>' 
                :
                    "<a href=''>Go to Course</a>" 
            }
            <a href="/course/${slug}">see details</a>
        </div>
        <div class="course-price flex justify-between">
            <p>${price} $</p>
            <p>50 Hour Course</p>
        </div>
    </div>
</div>

    `
};
export default course;