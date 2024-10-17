export default class ContentFile {
    upload(url) {
        const title = document.getElementById("content-title").value;
        const description = document.getElementById("content-description").value;
        let isEveryFieldFilled = title && description;
        if(!isEveryFieldFilled) return;

        // If no video file is attached
        if(!hasFile.value) {
            this.withoutFileUpload(url, title, description);
            return;
        }

        showProgress(title);
        initiateResumable(title, description);

        resumable.value.resumable.upload();

        ShowFileUploadProgress();

        uploadOnSuccess();
    }

    async withoutFileUpload(url, title, description) {
        const status = await axios.post(url, { title, description });
        contents.value.map(content => {
            let isNotSameContent = status.data.id !== content.id;
            if(isNotSameContent) return;
            content.title = title;
            content.description = description;
        });
    }
}
