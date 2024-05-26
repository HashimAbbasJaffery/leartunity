<x-layout>
    <div class="send-application container mx-auto mt-8">
        @if($isAllowed)
            <x-user.application-form/>
        @elseif($application->status === 0) 
            <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
                <span class="font-medium" style="font-weight: bold">Pending: </span> Your Application is in pending phase
            </div>
        @elseif($application->status === 1)
            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                <span class="font-medium" style="font-weight: bold">Interview: </span> You are invited to give interview in your suitable time, Click here to choose the timing
            </div>
        @elseif($application->status === 2)
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-medium" style="font-weight: bold">Accepted: </span> Congratulations!! You are now Instructor
            </div>
        @elseif($application->status === 3)
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span class="font-medium" style="font-weight: bold">Rejected!</span> Sorry, we didn't think you are suitable for this right now, you can submit another application at {{ \Carbon\Carbon::parse($application->updated_at)->addMonth()->format("d-M-Y") }}, or submit a ticket if you think something is wrong
        </div>
        @endif

    </div>
</x-layout>