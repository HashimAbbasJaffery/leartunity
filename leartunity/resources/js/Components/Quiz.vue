<template>
  <div class="content-quiz">
                        <div class="description">
                            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                <span class="font-medium">That's fantastic! Your score of 1% on the quiz shows you've mastered the material.</span>
                            </div>
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">1% isn't the end! Keep practicing, you've got this!</span>
                            </div>
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <span class="font-medium">You need to score 1% in order to be eligible for certification...</span>
                                </div>
                                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                    <span class="font-medium">You have Passed the Exam with score of 11%</span>
                                </div>
                        </div>
                        <div class="questions">
                            <form method="POST"  name="submitQuiz" style="display: inline-block;" id="submitQuiz" action="#">
                                    <h1 class="text-xl font-bold mb-2">Question No. 1</h1>

                                        <div class="question mb-8">
                                            <p>The Question</p>
                                            <ul class="mt-3">
                                                <li><input class="mr-2" type="radio" name="1" value="1">True</li>
                                                <li><input class="mr-2" type="radio" name="1" value="0">False</li>
                                            </ul>
                                        </div>

                                        <div class="question mb-8">

                                            <p>The Question</p>
                                            <ul class="mt-3">

                                                <li><input class="mr-2" value="f">test</li>
                                            </ul>
                                        </div>
                                    <input type="submit" value="Submit" style="border-radius: 0px; width: 20%; cursor: pointer;">
                                </form>

                        </div>
                    </div>
</template>

<script setup>
</script>

<style>

</style>
