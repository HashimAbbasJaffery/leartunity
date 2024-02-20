const result = () => {
    return `
    <a href="/courses">
        <div class="teacher flex mb-4">
        <div class="teacher-pic mr-2">
            <img src="https://placehold.co/50x50" style="border-radius: 50px"/>
        </div>
        <div class="teacher-detail">
            <h1 class="mb-0" style="height: 18px;">Hashim Abbas</h1>
            <span style="font-size: 13px;">
            {!! calculateReviewStars(4) !!}
            </span>
        </div>
        </div>
    </a>
    `
}
export default result;