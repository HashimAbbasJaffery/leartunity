import rsmble from "resumablejs";

import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
export default class Resumable {
    constructor(url) {
        this.resumable = new rsmble({
            target: `${url}`,
            method: "POST",
            fileType: ['mp4', 'mov'],
            chunkSize: 10*1024*1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
            headers: {
                'Accept': 'application/json'
            },
            testChunks: false,
            throttleProgressCallbacks: 1,
        });

        this.resumable.on("fileAdded", function(file) {
            console.log("start")
        })


        // this.resumable.on("fileSuccess", function(file) {
        //     const progressBar = document.querySelector(".progress-bar");
        //     progressBar.classList.add("none")
        //     progressBar.classList.remove("block");

        //     const page = usePage();
        //     const url = page.url;

        //     setTimeout(() => {
        //         router.visit(url, {
        //             except: []
        //         })
        //     }, 2000)
        // })

        this.resumable.on('fileError', function (file, response) { // trigger when there is any error
            console.log(response);
        });
    }
}
