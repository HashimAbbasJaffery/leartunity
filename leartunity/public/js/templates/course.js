import calculateReviewStars from "../helpers/stars.js";
const course = (data, user_id = null, rate = 1, currency = "$") => {
    const
    {
        author,
        title,
        description,
        price,
        is_purchased,
        slug,
        stripe_id,
        thumbnail,
        status,
        id
     } = data;
    const { name } = author;
    const { reviews } = data;
    const { stars } = data;
    const { profile } = author;
    console.log(rate);
    return `
    <div class="course">
    <div class="course-header" style="position: relative">
        ${
            (is_purchased)
                ?
            "<div class='course-pill bg-black text-white px-2 py-1 text-xs' style='border-radius: 10px;position: absolute; right: 10px; top: 10px;'><p>Purchased</p></div>"
                :
            ""
        }
        <img style="border-radius: 10px;" src="${thumbnail ? '/course/' + thumbnail : 'https://placehold.co/600x400'}" height="600" width="400" alt="">
    </div>
    <div class="course-instructor mt-4 flex">
        <img src="${ profile?.profile_pic ? '/profile/' + profile.profile_pic : 'https://placehold.co/45x45' }" height="45" width="45"  class="rounded-full" alt="">
        <div class="instructor-details flex">
            <h2>${name}</h2>
            <div class="course-rating flex">
                ${ calculateReviewStars(reviews?.stars ?? 0) }
            </div>
        </div>
    </div>

    <div class="course-detail mt-4">
        <div class="course-description">
            <h1 style="font-size: 15px; font-weight: bold; margin-bottom: 5px;">
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
            <a href="/instructor/course/${slug}">Manage</a>

        </div>
        <div class="course-price flex justify-between">
            <p>${ Math.round(price * (rate)) } ${currency}</p>
            <p>50 Hour Course</p>
        </div>
    </div>
</div>

    `
};
export default course;

