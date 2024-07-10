@props(["id"])
<div class="question m-4 mt-9">
    <p>Write the question...</p>
    <input type="text" name="boolean-{{ $id }}" id="b-{{ $id }}" style="width: 100%">
    <div class="keys mt-4">
        <p>Option 1: </p>
        <div class="answer flex items-center">
            <p class="mr-5">True</p>
            <div class="is-correct flex items-center">
                <p class="mr-2">Correct?</p>
                <input type="radio" name="b-key-1-{{ $id }}" id="">
            </div>
        </div>
    </div>
    <div class="keys mt-4">
        <p>Option 2: </p>
        <div class="answer flex items-center">
            <p class="mr-5">False</p>
            <div class="is-correct flex items-center">
                <p class="mr-2">Correct?</p>
                <input type="radio" name="b-key-2-{{ $id }}" id="">
            </div>
        </div>
    </div>
</div>