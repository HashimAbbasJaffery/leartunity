export default class ContentFile {
    upload() {
        const title = document.getElementById("content-title").value;
        const description = document.getElementById("content-description").value;
        let isEveryFieldFilled = title && description;
        if(!isEveryFieldFilled) return;
        const url = getUploadURL();

        // If no video file is attached
        if(!hasFile.value) {
            withoutFileUpload(url, title, description);
            return;
        }

        showProgress(title);
        initiateResumable(title, description);

        resumable.value.resumable.upload();

        ShowFileUploadProgress();

        uploadOnSuccess();
    }
}
