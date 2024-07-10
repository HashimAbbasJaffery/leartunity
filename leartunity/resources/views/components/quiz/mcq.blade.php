@props(["id"])
<div class="question m-4 mt-9">
            <p>Write the question...</p>
            <input type="text" name="question-{{ $id }}" id="q-{{ $id }}" style="width: 100%">
            <div class="keys mt-4">
                <p>Option 1: </p>
                <div class="answer flex items-center">
                    <input type="text" name="q-answer-1-{{ $id }}" class="mt-2 mr-2">
                    <div class="is-correct flex items-center">
                        <p class="mr-2">Correct?</p>
                        <input type="checkbox" name="q-key-1-{{ $id }}" id="">
                    </div>
                </div>
            </div>
            <div class="keys mt-4">
                <p>Option 2: </p>
                <div class="answer flex items-center">
                    <input type="text" name="q-answer-2-{{ $id }}"  class="mt-2 mr-2">
                    <div class="is-correct flex items-center">
                        <p class="mr-2">Correct?</p>
                        <input type="checkbox" name="q-key-2-{{ $id }}" id="">
                    </div>
                </div>
            </div>
            
            <div class="keys mt-4">
                <p>Option 3: </p>
                <div class="answer flex items-center">
                    <input type="text" name="q-answer-3-{{ $id }}"  class="mt-2 mr-2">
                    <div class="is-correct flex items-center">
                        <p class="mr-2">Correct?</p>
                        <input type="checkbox" name="q-key-3-{{ $id }}" id="">
                    </div>
                </div>
            </div>
            
            <div class="keys mt-4">
                <p>Option 4: </p>
                <div class="answer flex items-center">
                    <input type="text" name="q-answer-4-{{ $id }}"  class="mt-2 mr-2">
                    <div class="is-correct flex items-center">
                        <p class="mr-2">Correct?</p>
                        <input type="checkbox" name="q-key-4-{{ $id }}" id="">
                    </div>
                </div>
            </div>
            
        </div>