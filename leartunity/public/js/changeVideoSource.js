function changeVideoSource(player, newSource) {
    const spinner = document.querySelector(".spinner");
    spinner.style.display = "block";
    const videoSource = document.querySelector('video');
    console.log(videoSource);
    videoSource.src = newSource;

    // Preload new video
    const newVideo = new Audio(newSource);
    newVideo.preload = 'auto';
    newVideo.load();

    // Change Plyr player's source
    player.source = {
        type: 'video',
        sources: [
            {
                src: newSource,
                type: 'video/mp4',
            },
        ],
    };
    spinner.style.display = "none";
}