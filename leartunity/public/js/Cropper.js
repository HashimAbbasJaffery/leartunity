class Cropper {
    constructor(width, height, type, element) {
        this.$image_crop = $(element).croppie({
            enableExif: true,
            viewport: {width, height, type},
            boundary:{
            width:300,
            height:300
            }
        });
    }
    get() {
        return this.$image_crop;
    }
    destroy() {  
        this.$image_crop.croppie("destroy");
    }
    bindPicture(element) {
        var reader = new FileReader();
        reader.onload = (event) => {
            this.$image_crop.croppie('bind', {
                url: event.target.result
            }) 
        }
        reader.readAsDataURL(element.files[0]);
    }
    upload(callback) {
        this.$image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(resp => {
            callback(resp);
        })
    }
}