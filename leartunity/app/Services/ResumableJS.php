<?php

namespace App\Services;
use Illuminate\Http\Request;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class ResumableJS {
    public function upload(Request $request, callable $closure, callable $onFileMissing = null) {
        $reciever = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));
        if($reciever->isUploaded() === false) {
            $onFileMissing();
            return;
        }

        $save = $reciever->receive();

        if($save->isFinished()) {
            $file = $save->getFile();
            $fileName = time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path("uploads"), $fileName);

            $closure($fileName);
        }

        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }
}
