<?php

namespace App\Http\Controllers\Admin;

use App\Dictionaries\UploadType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/*
 * Upload Data to Cloudinary
 * */

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('domain.upload.home.dashboard');
    }

    public function fileManager()
    {
        return view('admin.settings.filemanager');
    }

    public function data()
    {
        return view('domain.upload.home.upload');
    }

    /**
     * Cloudinary Upload
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $uploadType = $request->input('type');

        //Single File
        $fileInput = $request->_fileinput_w0;
        //Multiple File
        $fileInputMultiple = $request->_fileinput_w1;
        $data = [];
        //dd($fileInput);
        //dd($fileInputMultiple);
        $result = null;
        if ($request->hasFile('_fileinput_w0')) {
            $result = $request->_fileinput_w0->storeOnCloudinary('avatar');
            $item = $this->doUploadFile($result);
            //Wraper file
            $data['files'][] = $item;
        }
        if ($request->hasFile('_fileinput_w1')) {
            foreach ($fileInputMultiple as $itemFile) {
                $resultItem = $itemFile->storeOnCloudinary('avatar');
                $item = $this->doUploadFile($resultItem);
                //Wraper file
                $data['files'][] = $item;
            }
        }

        return response()->json($data, 200);
    }

    /**
     * Cloudinary Upload
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadStorage(Request $request)
    {
        $uploadType = $request->input('type');

        //Single File
        $fileInput = $request->_fileinput_w0;
        //Multiple File
        $fileInputMultiple = $request->_fileinput_w1;
        $data = [];
        //dd($fileInput);
        //dd($fileInputMultiple);
        $result = null;
        if ($request->hasFile('_fileinput_w0')) {
            // Get filename with the extension
            $filenameWithExt = $request->_fileinput_w0->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->_fileinput_w0->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.str_shuffle(time()).'.'.$extension;
            $result = $request->_fileinput_w0->storeAs('public/images', $fileNameToStore);
            //public/images/Screenshot_1_1663927127.png
            //asset('storage/images/bee6098d-2626-4569-828f-e194f28fee9a_1663926070.jpg');

            $item = $this->doUploadFileStorage($result);
            //Wraper file
            $data['files'][] = $item;
        }
        if ($request->hasFile('_fileinput_w1')) {
            foreach ($fileInputMultiple as $itemFile) {
                //Storage::disk('local')->put($itemFile, 'Contents');

                // Filename to store
                $fileNameToStore = $filename.'_'.str_shuffle(time()).'.'.$extension;
                $result = $request->$itemFile->storeAs('public/images', $fileNameToStore);
                //public/images/Screenshot_1_1663927127.png
                //asset('storage/images/bee6098d-2626-4569-828f-e194f28fee9a_1663926070.jpg');

                $item = $this->doUploadFileStorage($result);

                //Wraper file
                $data['files'][] = $item;
            }
        }
        //_fileinput_wImg
        for ($i = 1; $i <= 6; $i++) {
            if ($request->hasFile('_fileinput_wImg'.$i)) {
                // Get filename with the extension
                $filenameWithExt = $request->file('_fileinput_wImg'.$i)->getClientOriginalName();

                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('_fileinput_wImg'.$i)->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename.'_'.str_shuffle(time()).'.'.$extension;
                $result = $request->file('_fileinput_wImg'.$i)->storeAs('public/images', $fileNameToStore);
                //public/images/Screenshot_1_1663927127.png
                //asset('storage/images/bee6098d-2626-4569-828f-e194f28fee9a_1663926070.jpg');

                $item = $this->doUploadFileStorage($result);
                //Wraper file
                $data['files'][] = $item;
            }
        }
        //_fileinput_wImgList
        if ($request->hasFile('_fileinput_wImgList')) {
            // Get filename with the extension
            $filenameWithExt = $request->_fileinput_wImgList->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->_fileinput_wImgList->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.str_shuffle(time()).'.'.$extension;
            $result = $request->_fileinput_wImgList->storeAs('public/images', $fileNameToStore);
            //public/images/Screenshot_1_1663927127.png
            //asset('storage/images/bee6098d-2626-4569-828f-e194f28fee9a_1663926070.jpg');

            $item = $this->doUploadFileStorage($result);
            //Wraper file
            $data['files'][] = $item;
        }

        return response()->json($data, 200);
    }

    /**
     * Upload single file
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadSingle(Request $request)
    {
        //List file
        $fileList = $request->files;
        $upload_max_size = ini_get('upload_max_filesize'); //2M
        //Convert to bytes
        $upload_max_sizeByte = dataConvertToBytes($upload_max_size);
        //dd($upload_max_size);
        $post_max_size = ini_get('post_max_size'); //8M

        $data = [];
        $result = null;
        //$uploadType = UploadType::CLOUDINARY;
        $uploadType = config('app.upload_type');

        foreach ($fileList as $indexFile => $itemFile) {
            //Check $itemFile is arrayed
            if (is_array($itemFile)) {
                $indexMultiple = $indexFile;
                $itemMultiple = $itemFile;
                foreach ($itemMultiple as $indexFileMultiple => $itemFile) {
                    //$itemFile: Symfony\Component\HttpFoundation\File\UploadedFile
                    //$fileRequest: Illuminate\Http\UploadedFile Index _fileinput_w3 -> 0
                    $fileRequest = $request->file($indexMultiple)[$indexFileMultiple];
                    // Get filename with the extension
                    $filenameWithExt = $fileRequest->getClientOriginalName();
                    //Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $fileRequest->getClientOriginalExtension();
                    $size = $fileRequest->getSize();

                    //15.03.2023 Check file size is less than $upload_max_size
                    if ($size > $upload_max_size) {
                        //$data['error'] = 'File size is too large. Maximum file size is '.$upload_max_size;
                        //return response()->json($data, 200);
                    }

                    $type = $fileRequest->getClientOriginalExtension();
                    // Filename to store
                    $fileNameToStore = $filename.'_'.str_shuffle(time()).'.'.$extension;
                    //$result = $fileRequest->storeAs('public/images', $fileNameToStore);
                    //$result = $fileRequest->store('images', 's3');
                    ///Todo seperate file folder ex: Files/Product/51_09.jpg
                    $fullPath = $this->getFullPath(); //public/images/202303
                    //Upload file to s3
                    switch ($uploadType) {
                        case UploadType::CLOUDINARY:

                            //dd($fullPath);
                            $result = $fileRequest->storeOnCloudinaryAs($fullPath, $fileNameToStore);

                            $filePath = $result->getPublicId().'.'.$result->getExtension();
                            $result = $filePath;
                            break;
                        case UploadType::S3:

                            //dd($fullPath);
                            $result = $fileRequest->storeAs($fullPath, $fileNameToStore, 's3');
                            //dd($result);
                            break;
                    }
                    //$result = $fileRequest->storeAs($fullPath, $fileNameToStore, 's3');
                    //public/images/Screenshot_1_1663927127.png
                    //asset('storage/images/bee6098d-2626-4569-828f-e194f28fee9a_1663926070.jpg');

                    //  return env('AWS_URL', 'https://vndevslar.s3.ap-northeast-1.amazonaws.com').$filename;
                    //dd($result);
                    //$path = $request->file('image')->store('images', 's3');
                    $baseUrl = env('AWS_URL', 'https://vndevslar.s3.ap-northeast-1.amazonaws.com');
                    if ($uploadType == 2) {
                        $cloudinaryname = config('cloudinary.cloud_app');
                        $baseUrl = "http://res.cloudinary.com/$cloudinaryname/image/upload/";
                    }
                    $fileInfo = [
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'type' => $type,
                        //'path' => $fullPath,
                        'path' => $fullPath.'/'.$fileNameToStore,
                        'path_store' => $fileNameToStore,
                        'url' => $baseUrl.'/'.$fullPath.'/'.$fileNameToStore,
                    ];

                    $item = $this->doUploadFileStorage($result, $uploadType, $fileInfo);
                    //Todo Logging file upload

                    //Wraper file
                    $data['files'][] = $item;
                }
            } else {
                //dd('Upload single file');
                //$indexFile: _fileinput_w2
                //Illuminate\Http\UploadedFile
                $fileRequest = $request->file($indexFile);
                // Get filename with the extension
                $filenameWithExt = $request->file($indexFile)->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($indexFile)->getClientOriginalExtension();
                $size = $request->file($indexFile)->getSize(); //Example 2708308 bytes

                //15.03.2023 Check file size is less than $upload_max_size
                if ($size > $upload_max_size) {
                    //$data['files'][]['error'] = 'File size is too large. Maximum file size is '.$upload_max_size;

                    //return response()->json($data, 404);
                }
                $type = $request->file($indexFile)->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename.'_'.str_shuffle(time()).'.'.$extension;
                //$fileNameToStore = Str::limit($filename, 100) . '_' . time() . '.' . $extension;
                //$result = $request->file($indexFile)->storeAs('public/images', $fileNameToStore);
                //Cut file name if file name is too long
                //$fileNameToStore = $this->cutFileName($fileNameToStore);

                /*Full Path*/
                $fullPath = $this->getFullPath();
                $result = $fullPath.'/'.$fileNameToStore;

                //Upload file to s3
                //$result = $request->file($indexFile)->storeAs($fullPath, $fileNameToStore, 's3');
                switch ($uploadType) {
                    case UploadType::CLOUDINARY:
                        //$result = $request->file($indexFile)->storeAs($fullPath, $fileNameToStore, 'cloudinary2');
                        //public/images/2022/12/80_07_6284168198.jpg
                        $result = $request->file($indexFile)->storeOnCloudinaryAs($fullPath, $fileNameToStore);

                        //dd($result->getPublicId().'.'.$result->getExtension());
                        $filePath = $result->getPublicId().'.'.$result->getExtension();
                        $result = $filePath;
                        break;
                    case UploadType::S3:
                        //dd($fileNameToStore);
                        //public/images/202302/Picture12_6707615116.png
                        $result = $request->file($indexFile)->storeAs($fullPath, $fileNameToStore, 's3');
                        //Check $result upload fail
                        if ($result == false) {
                            //return $this->responseError('Upload file fail');
                        }

                        break;
                }
                //$result = $request->file($indexFile)->store('images', 's3');
                //public/images/Screenshot_1_1663927127.png
                //asset('storage/images/bee6098d-2626-4569-828f-e194f28fee9a_1663926070.jpg');

                //  return env('AWS_URL', 'https://vndevslar.s3.ap-northeast-1.amazonaws.com').$filename;
                //dd($result);
                //$path = $request->file('image')->store('images', 's3');
                /*File Infor*/
                $fileInfo = [
                    'name' => $filename,
                    'extension' => $extension,
                    'size' => $size,
                    'type' => $type,
                    'path' => $fullPath.'/'.$fileNameToStore,
                    'path_store' => $fileNameToStore,
                    'url' => env('AWS_URL', 'https://vndevslar.s3.ap-northeast-1.amazonaws.com').'/'.$fullPath.'/'.$fileNameToStore,
                ];

                $item = $this->doUploadFileStorage($result, $uploadType, $fileInfo);

                //Wraper file
                $data['files'][] = $item;
            }
        }

        return response()->json($data, 200);
    }

    /*
     * Function get full path by year month
     * */
    public function getFullPath()
    {
        /*Path Date Year*/
        $pathDateYear = date('Y');
        /*Path Date Month*/
        $pathDateMonth = date('m');
        /*Path Date Day*/
        $pathDateDay = date('d');

        return 'public/images/'.$pathDateYear.$pathDateMonth;
    }

    /**
     * Upload multiple file
     *
     * @return \Illuminate\Http\Response
     *
     * @created 2022-10-14 Dungpx
     */
    public function uploadMultipleToS3(Request $request)
    {
        //List file
        $fileList = $request->files;
        $fileInput = $request->_fileinput_w3;
        $data = [];
        $result = null;

        //dd($request->all());

        foreach ($fileList as $indexMultiple => $itemMultiple) {
            foreach ($itemMultiple as $indexFile => $itemFile) {
                //$itemFile: Symfony\Component\HttpFoundation\File\UploadedFile
                //$fileRequest: Illuminate\Http\UploadedFile Index _fileinput_w3 -> 0
                $fileRequest = $request->file($indexMultiple)[$indexFile];
                // Get filename with the extension
                $filenameWithExt = $fileRequest->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $fileRequest->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename.'_'.str_shuffle(time()).'.'.$extension;
                //$result = $fileRequest->storeAs('public/images', $fileNameToStore);
                //$result = $fileRequest->store('images', 's3');
                $fullPath = $this->getFullPath();
                //Upload file to s3
                $result = $fileRequest->storeAs($fullPath, $fileNameToStore, 's3');
                //public/images/Screenshot_1_1663927127.png
                //asset('storage/images/bee6098d-2626-4569-828f-e194f28fee9a_1663926070.jpg');

                //  return env('AWS_URL', 'https://vndevslar.s3.ap-northeast-1.amazonaws.com').$filename;
                //dd($result);
                //$path = $request->file('image')->store('images', 's3');

                $item = $this->doUploadFileStorage($result, 3);

                //Wraper file
                $data['files'][] = $item;
            }
        }

        return response()->json($data, 200);
    }

    /**
     * Cloudinary Upload
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadEditor(Request $request)
    {
        //Single File
        //Multiple File

        $isUploadSuccess = false;
        $data = ['url' => '', 'name' => ''];
        if ($request->hasFile('file')) {
            //$result = $request->file->storeOnCloudinary('avatar');
            //Store s3
            $result = $request->file->store('images', 's3');
            $item = $this->doUploadFileStorage($result, 3);
            //Wraper file
            $data = $item;
            $isUploadSuccess = true;
        }

        return response()->json($data, $isUploadSuccess ? 200 : 404);
    }

    /**
     * Cloudinary Upload
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadEditor2(Request $request)
    {
        Log::info('Upload Image');
        //Single File
        //Multiple File
        $uploadType = config('app.upload_type');

        //3030024 bytes
        $fileSize = $request->file->getSize();
        //Check file size > 5 MB
        if ($fileSize > 5 * 1024 * 1024) {
            return $this->responseError('File size must be less than 5 MB');
        }
        $isUploadSuccess = false;
        $data = ['url' => '', 'name' => ''];
        if ($request->hasFile('file')) {
            //$result = $request->file->storeOnCloudinary('avatar');
            switch ($uploadType) {
                case UploadType::CLOUDINARY:
                    $result = $request->file->storeOnCloudinary('avatar');
                    break;
                case UploadType::S3:
                    $path = Storage::disk('s3')->put('images', $request->file);
                    //https://d1mwkdc4gsui44.cloudfront.net/images/wgctLtfM4iVt54mwygquMbfoUQ03B03q1tuvieKM.png
                    $path = Storage::disk('s3')->url($path);

                    $result = $path;
                    break;
            }
            $item = $this->doUploadFile($result, $uploadType);
            //Wraper file
            $data = $item;
            $isUploadSuccess = true;
        }

        return response()->json($data, $isUploadSuccess ? 200 : 404);
    }

    /*
     * Upload Single File
     * */
    private function doUploadFile($result, $uploadType = 2)
    {
        $item = [];
        if ($uploadType == UploadType::CLOUDINARY) {
            $imagePath = $result->getPublicId().'.'.$result->getExtension();
            $item['size'] = $result->getSize();
        } else {
            $imagePath = $result;
            $item['size'] = '';
        }

        $item['name'] = 'Profile.jpg';
        //$item['type'] = $result->getFileType();
        $item['type'] = 'image/png';
        if ($uploadType == UploadType::CLOUDINARY) {
            $cloudinaryname = config('cloudinary.cloud_app');
            $appBaseUrl = "http://res.cloudinary.com/$cloudinaryname/image/upload/";
            $height = 915;
            $width = 515;
            $cropValue = '/h_'.$height.',w_'.$width.',c_fill,q_auto,f_auto/';

            $item['base_url'] = $appBaseUrl;
            $item['path'] = $imagePath;
            $item['url'] = $appBaseUrl.$cropValue.$imagePath; //$result->getPublicId();
            $item['url_full'] = $appBaseUrl.$imagePath; //$result->getPublicId();
            $item['filelink'] = $appBaseUrl.$imagePath;
            $item['delete_url'] = route('delete-image');
        } else {
            $item['url'] = $imagePath;
            $item['url_full'] = $imagePath;
            $item['filelink'] = $imagePath;
            $item['delete_url'] = route('delete-image');
        }

        return $item;
    }

    /*
     * Upload Single File
     * Type Storage: 1 Local, 2 Cloudinary, 3 S3
     *  //public/images/Screenshot_1_1663927127.png
     * */
    private function doUploadFileStorage($result, $type = 1, $fileInfo = [])
    {
        //dd($fileInfo);
        $item = [];
        if ($type == UploadType::CLOUDINARY) {
            $imagePath = $result;
        }
        //$imagePath = $result;
        if ($type == UploadType::S3) {
            $imagePath = $fileInfo['path'] ?? $result;
        }

        $item['name'] = 'Profile.jpg';
        //$item['type'] = $result->getFileType();
        $item['type'] = 'image/png';
        $item['size'] = '';

        //http://localhost/vaixgroup/fujiken/public/storage/public/images/Screenshot_1_1663927184.png
        $appBaseUrl = asset('storage');
        if ($type == 2) {
            //https://res.cloudinary.com/dhploi5y1/image/upload/v1669881623/public/images/2022/12/80_07_8531819668.jpg.jpg
            //https://res.cloudinary.com/dhploi5y1/image/upload/v1669881622/public/images/2022/12/80_02_2851968062.jpg
            $cloudinaryname = config('cloudinary.cloud_app');
            $appBaseUrl = "http://res.cloudinary.com/$cloudinaryname/image/upload/";
        }

        if ($type == 3) {
            $appBaseUrl = env('AWS_URL', 'https://vndevslar.s3.ap-northeast-1.amazonaws.com');
            if ($appBaseUrl == '') {
                $appBaseUrl = config('filesystems.disks.s3.url');
            }
        }

        $fullUrl = $appBaseUrl.'/'.$fileInfo['path_store'] ?? $imagePath;
        if ($type == 3) {
            $fullUrl = $appBaseUrl.'/'.$imagePath;
        }

        //http://localhost/vaixgroup/fujiken/public/storage/public/images/Screenshot_1_1663927695.png
        //$fullUrl = Str::replace('public/images', 'images', $fullUrl);

        $item['base_url'] = $appBaseUrl;
        //$item['path'] = Str::replace('public/images', 'images', $imagePath);
        $item['path'] = $appBaseUrl .'/'.$imagePath;
        $item['path_store'] = $fileInfo['path_store'] ?? $imagePath;
        $item['url'] = $fullUrl;
        //$item['url'] = $appBaseUrl . '/'.$imagePath;
        $item['url_full'] = $fullUrl;
        //Tinymce
        $item['location'] = $fullUrl;
        $item['filelink'] = $fullUrl;
        $item['delete_url'] = route('delete-image', ['type' => $type, 'path' => $imagePath]);

        return $item;
    }

    /*
     * Upload nhiều ảnh
     *
     * @created 2021/09/30
     * */
    public function uploadMultiple(Request $request)
    {
        $item = [];
        $uploadType = $request->input('type');

        $fileInput = $request->_fileinput_w0;
        $result = null;
        if ($request->hasFile('_fileinput_w0')) {
            $result = $request->_fileinput_w0->storeOnCloudinary('avatar');
        }

        $imagePath = $result->getPublicId().'.'.$result->getExtension();

        $item['name'] = 'Profile.jpg';
        //$item['type'] = $result->getFileType();
        $item['type'] = 'image/png';
        $item['size'] = $result->getSize();

        $cloudinaryname = config('cloudinary.cloud_app');
        $appBaseUrl = "http://res.cloudinary.com/$cloudinaryname/image/upload/";
        $height = 915;
        $width = 515;
        $cropValue = '/h_'.$height.',w_'.$width.',c_fill,q_auto,f_auto/';
        $item['base_url'] = $appBaseUrl;
        $item['path'] = $imagePath;
        $item['url'] = $appBaseUrl.$cropValue.$imagePath; //$result->getPublicId();
        $item['filelink'] = $appBaseUrl.$imagePath;
        $item['delete_url'] = route('delete-image');
        //Wraper file
        $data['files'][] = $item;

        return response()->json($data, 200);
    }

    public function uploadTinyMce(Request $request)
    {
        $fileParam = 'file';
        $result = [];
        $fileInput = $request->$fileParam;
        $result = null;
        if ($request->hasFile($fileParam)) {
            $result = $request->$fileParam->storeOnCloudinary('postarticle');
            $imagePath = $result->getPublicId().'.'.$result->getExtension();

            $cloudinaryname = config('cloudinary.cloud_app');
            $appBaseUrl = "http://res.cloudinary.com/$cloudinaryname/image/upload/";
            //Response
            $height = 515;
            $width = 915;
            //$cropValue = '/h_' . $height . ',w_' . $width . ',c_fill,q_auto,f_auto/';
            $cropValue = '/c_fill,q_auto,f_auto/';
            $urlLocationImage = $appBaseUrl.$cropValue.$imagePath; //$result->getPublicId();

            $result = ['location' => $urlLocationImage];
        }

        return response()->json($result, 200);
    }

    /*
     * Todo delete image
     *
     * */
    public function uploadDelete(Request $request)
    {
        //Get file path
        $filePath = $request->input('path');
        $getId = $request->input('id_file');
        //Checl item exits and delete
        /*if (Storage::disk('local')->exists($filePath)) {
            Storage::delete($filePath);
        }*/
        //Amazone s3 delete file
        $s3 = Storage::disk('s3');
        //Check file exits
        if ($s3->exists($filePath)) {
            $s3->delete($filePath);
        }

        return response()->json(['msg' => 'Success'], 200);
    }

    public function file()
    {
        //List file
        $user = Auth::guard('admin')->user();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function fileDownloadUrl(Request $request)
    {
        //$path = "https://www.itsolutionstuff.com/assets/images/logo-it.png";
        $path = 'https://res.cloudinary.com/demo/image/fetch/q_auto/https://vndevslar.s3.ap-northeast-1.amazonaws.com/images/eglQJqtT5uciXY0kvt2OuL0VGGKSB3DKELkhCUR1.jpg';
        //https://res.cloudinary.com/dhploi5y1/image/fetch/q_auto/https://vndevslar.s3.ap-northeast-1.amazonaws.com/images/eglQJqtT5uciXY0kvt2OuL0VGGKSB3DKELkhCUR1.jpg
        Storage::disk('s3')->put('images/itsolutionstuff.png', file_get_contents($path));

        $path = Storage::path('itsolutionstuff.png');

        return response()->download($path);
    }

    /*Cut file name */
    private function cutFileName(string $fileNameToStore)
    {
        $fileNameToStore = Str::slug($fileNameToStore);
        //check length grater than 255
        if (strlen($fileNameToStore) > 200) {
            //Cut first 100 character
            $fileNameToStore = substr($fileNameToStore, 0, 200);
        }

        return $fileNameToStore;
    }

    private function responseError(string $string)
    {
        return response()->json(['msg' => $string], 400);
    }

    private function convertToBytes(bool|string $upload_max_size)
    {
        $upload_max_size = trim($upload_max_size);
        $last = strtolower($upload_max_size[strlen($upload_max_size) - 1]);
        switch ($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $upload_max_size *= 1024;
                // no break
            case 'm':
                $upload_max_size *= 1024;
                // no break
            case 'k':
                $upload_max_size *= 1024;
        }

        return $upload_max_size;
    }
}
