<x-layout>
    <div class="container mx-auto mt-8">
        <form method="POST" name="addQuestion" id="addQuestion" style="display: inline-block;">
            @csrf
            <div class="questions" id="questions"></div>

            <div class="add-question flex items-center" x-data="{ name: 'Add Question', isOpen: false }" >
                <button class="m-4" @click.prevent="isOpen = !isOpen" style="background: var(--primary); color: white; padding: 10px; border-radius: 5px;" x-text="name"></button>
                <div x-data="addField" @click.outside="isOpen = false" class="options" x-show="isOpen" style="border: 1px solid black; padding: 10px;-webkit-box-shadow: -1px 1px 3px 0px rgba(0,0,0,0.75);-moz-box-shadow: -1px 1px 3px 0px rgba(0,0,0,0.75);box-shadow: -1px 1px 3px 0px rgba(0,0,0,0.75);" transition>
                    <ul>
                        <li class="py-2" @click="addElement(1)">True/False</li>
                        <li class="py-2" @click="addElement(0)">Multiple Choice Question</li>
                    </ul>
                </div>
            </div>
            <div class="required-score m-4 mt-8">
                <p>Minimum Required score in %</p>
                <input type="number" name="min-score">
            </div>

            <input type="submit" value="Submit" style="border-radius: 0px; margin: 10px;">
        </form>
    </div>
    @push("scripts")
        <script>

        </script>
        <script>
            document.addEventListener("alpine:init", function() {
                Alpine.data('addField', () => ({
                    elements: 0,

                    addElement(type) {
                        this.elements++

                        const questions = document.getElementById("questions");

                        if(type === 1) {
                            questions.insertAdjacentHTML('beforeend', `<x-quiz.boolean id="${this.elements}" />`)
                        } else if (type === 0){
                            questions.insertAdjacentHTML('beforeend', `<x-quiz.mcq id="${this.elements}" />`)
                        }
                    }
                }))
            })
        </script>
    @endpush 
</x-layout>