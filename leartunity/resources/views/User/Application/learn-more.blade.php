<x-layout>
    <div class="learn-more container mx-auto mt-4">
        <div class="intro mb-3">
            <h1 style="font-size: 25px;">@lang("Learn More")</h1>
            <p>@lang("There are three phases of you application. Submitting application, interview phase, result of the application.")</p>
        </div>
        
        <div class="submitting" class="mt-3 mb-3">
            <h2 style="font-size: 19px;">@lang("Submitting Application")</h2>
            <p>@lang("In this phase you will need to give these information")</p>
            <ul class="mt-3" style="list-style-type: circle;">
                <li>@lang("Your Fullname")</li>
                <li>@lang("Your Email (It will be confidential)")</li>
                <li>@lang("Your age (minimum age is 21 to apply)")</li>
                <li>@lang("Your Qualification Level")</li>
                <li>@lang("Your Teaching Niche")</li>
                <li>@lang("Cover Letter")</li>
                <li>@lang("Any additional documents to support your cover letter (Optional)")</li>
            </ul>
        </div>
        <div class="interview mt-3">
            <h2 style="font-size: 19px;">@lang("Interview Phase")</h2>
            <p>@lang("If everything is Ok, and if you are eligible then we will ask you for an interview, Interview will be taken with related to your niche.")</p>
        </div>
        <div class="result mt-3">
            <h2 style="font-size: 19px;">@lang("Result Phase")</h2>
            <p>@lang("In this last stage you will be shown the status of your application. there are three status in this last phase,") <b>@lang("Accepted")</b> @lang("It means you are now Teacher/Instructor at leartunity. you can start making courses. and you can earn. ")<b>@lang("Rejected")</b> @lang("Your application was rejected due to some reason (The reason will be mentioned), then you may have to wait to end the cooldown until you can apply another application. ")<b>@lang("Need Additional Information")</b> @lang("In this status you may need to give additional information, after giving additional information your application will be proceeded furthermore. ")</p>

        </div>
    </div>
</x-layout>