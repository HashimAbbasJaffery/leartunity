<form action="{{ route('apply') }}" enctype="multipart/form-data" method="POST" style="display: inline;">
            @csrf
            <label for="fullname">
                <p>@lang("Fullname")</p>
                @error("fullname")
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
                <input type="text" value="{{ old('fullname') }}" class="mb-3 @error('fullname') border-red-500 @enderror" name="fullname" id="fullname">
            </label>
            <label for="email">
                <p>@lang("Email (It will be confidential)")</p>
                @error("email")
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
                <input type="text" value="{{ old('email') }}" class="mb-3 @error('email') border-red-500 @enderror" name="email" id="email">
            </label>
            <label for="age">
                <p>@lang("age (minimum 21 years)")</p>
                @error("age")
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
                <input type="number" min="21" value="{{ old('age') }}" class="mb-3 @error('age') border-red-500 @enderror" name="age" id="age">
            </label>
            <label for="qualification">
                <p>@lang("Qualification")</p>
                @error("qualification")
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
                <select name="qualification" class="w-1/2 px-2 mb-3 @error('qualification') border-red-500 @enderror" style="height: 35px" id="qualification">
                    <option value="matriculation">@lang("Matriculation")</option>
                    <option value="intermediate">@lang("Intermediate")</option>
                    <option value="undergraduate">@lang("Undergraduate")</option>
                    <option value="graduate">@lang("Graduate")</option>
                    <option value="post-graduate">@lang("Post-Graduate")</option>
                </select>
            </label>
            <label for="niche">
                <p>@lang("Niche")</p>
                @error("niche")
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
                <select name="niche" class="w-1/2 px-2 mb-3 @error('niche') border-red-500 @enderror" style="height: 35px" id="niche">
                    <option value="data-science">Data Science</option>
                    <option value="web-development">Web Development</option>
                    <option value="python">Python</option>
                </select>
            </label>
            <label for="cover_letter">
                <p>@lang("Cover Letter")</p>
                @error("cover_letter")
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
                <textarea name="cover_letter" id="cover_letter" style="resize: none; height: 100px;" class="w-1/2 @error('cover_letter') border-red-500 @enderror">{{ old('cover_letter') }}</textarea>
            </label>
            <label for="supporting-file">
                <p>@lang("Supporting File (Optional)")</p>
                @error("supporting-file")
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
                <input type="file" name="supporting-file" class="mb-3 @error('supporting-file') border-red-500 @enderror" id="supporting-file">
            </label>
            @error("t&c")
                <p class="text-red-500">{{ $message }}</p>
            @enderror
            <label for="t&c" class="mb-3 flex items-center">
                <input type="checkbox" style="margin: 0px" name="t&c" class="mb-3 @error("t&c") 'border-red-500' @enderror" id="t&c">
                <p style="padding: 0px;" class="ml-3">@lang("I have read Terms and Conditions, and I acknowledge that in case something went wrong, leartunity is not responsible for that")</p>
            </label>
            <input type="submit" style="border-radius: 0px; cursor: pointer;" class="mb-3" value="Submit">
        </form>