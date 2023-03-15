<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Concerns\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Hash, Storage};
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserService extends BaseService
{
    /**
     * @param \App\Repositories\UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function index($idUser){
        $user = $this->repository->whereId($idUser)->first();

        if (!$user) {
            return null;
        }

        return $user;
    }


    public function search($conditions = [])
    {
        $this->makeBuilder($conditions);

        if ($this->filter->has('name')) {
            $this->builder->where(function ($q) {
                $q->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower($this->filter->get('name')) . '%');
            });

            // Remove condition after apply query builder
            $this->cleanFilterBuilder('name');
        }
        if ($this->filter->has('email')) {
            $this->builder->where(function ($q) {
                $q->where(DB::raw('LOWER(email)'), 'like', '%' . strtolower($this->filter->get('email')) . '%');
            });

            // Remove condition after apply query builder
            $this->cleanFilterBuilder('email');
        }
        if ($this->filter->has('status')) {
            $this->builder->where(function ($q) {
                $q->where('status',$this->filter->get('status'));
            });

            // Remove condition after apply query builder
            $this->cleanFilterBuilder('status');
        }

        if ($this->filter->has('date_to') || $this->filter->has('date_end')) {
            $this->builder->where(function ($q) {
                $q->whereBetween('created_at', [$this->filter->get('date_to') ?? date('Y-m-d'), $this->filter->get('date_end')?? date('Y-m-d')]);
            });
            // Remove condition after apply query builder
            $this->cleanFilterBuilder('date_to');
        }

        return $this->endFilter();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(Request $request)
    {
        try {
            $data = $request->toArray();
            $data['password'] = Hash::make($request->input('password'));
            $data['role'] = USER_ROLE;
            $data['confirmation_code'] = rand(100000,999999);
            $user = $this->repository->create($data);
            
        } catch (\Exception $e) {
            return false;
        }

        return $user;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function confirmEmail(Request $request)
    {
        try {
            $email = $request->input('email');
            $code = $request->input('confirmation_code');
            $user = $this->repository->findByConfirmCode($email, $code);

            if($user) {
                $user->update([
                    'email_verified_at' => Carbon::now(),
                    'confirmation_code' => null
                ]);
            }
        } catch (\Exception $e) {
            return false;
        }

        return $user;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function update(Request $request, $id = null)
    {
        try {
            $user = $this->find($id ?? $request->input('id'));

            return $this->repository->updateByModel($user, [
                'name'  => $request->name ?? null,
                'email' => $request->email ?? null,
                'gender' => $request->gender ?? null,
                'birth' => $request->birth ? Carbon::parse($request->birth)->format('Y-m-d') : null,
                'confirmation_code' => $user->email_verified_at ? null : rand(100000,999999)
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function updateAvatar(Request $request)
    {
        try {
            $user = $this->find($request->user()->id);

            if ($request->hasFile('avatar')) {
                $uploadedFile = $request->file('avatar');
                $path = 'uploads/profiles/' . Carbon::now()->format('Ymd');
                $imageUploaded = Storage::disk('s3')->putFileAs($path, $uploadedFile, $this->getFileName($request->avatar->extension()));
                if($imageUploaded) {
                    !is_null($user->avatar_path) && Storage::delete($user->avatar_path);
                }
            }
            $userUpdated = $this->repository->updateByModel($user, ['avatar_path'  => $imageUploaded]);
        } catch (\Exception $e) {
            return '';
        }

        return $userUpdated->avatar_path;
    }

    /**
     * @param string $extension File extension
     *
     * @return string
     */
    private function getFileName($extension)
    {
        return time() . '.' . Str::random(40) . '.' . $extension;
    }

    /**
     * @param string $emailupdateAvatar
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function updateConfirmationCode($email)
    {
        try {
            $user = $this->findByEmail($email);
            $user->confirmation_code = rand(100000,999999);
            $user->save();
        } catch (\Exception $e) {
            return false;
        }

        return $user;
    }

    /**
     * User change password
     *
     * @param string $email
     * @param string $userId
     * @param string $password New password
     */
    public function changePassword($userId, $password, $email = null)
    {
        try {
            if($userId) {
                $user = $this->find($userId);
            }
            if($email) {
                $user = $this->findByEmail($email);
            }
            $user->password = Hash::make($password);
            $user->save();
            
        } catch (\Exception $e) {
            return null;
        }

        return $user;
    }

    /**
     * @param string $email
     *
     * @return mixed
     */
    public function findByEmail($email)
    {
        return $this->repository->findByEmail($email);
    }

    /**
     * @param string $email
     *
     * @return mixed
     */
    public function findUserUnverify($email)
    {
        return $this->repository->findUserUnverify($email);
    }

    /**
     * @param string $email
     *
     * @return mixed
     */
    public function findActiveUser($email)
    {
        return $this->repository->findActiveUser($email);
    }

    /**
     * @param array $user
     *
     * @return mixed
     */
    public function firstOrCreate($user)
    {
        $user['email_verified_at'] = now();
        $user['status'] = true;

        return User::firstOrCreate(
            ['email' => $user['email']],
            $user
        );
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function createOrUpdate($request)
    {
        // Looking for user not verify
        $user = $this->findUserUnverify($request->input('email'));
        if(!$user) {
            return $this->create($request);
        }
        return $this->update($request, $user->id);
    }

    /**
     * User change password
     *
     * @param string $email
     * @param string $userId
     * @param string $password New password
     */
    public function updateSocialAccount($userId, $request)
    {
        try {
            $user = $this->find($userId);
            $type = $request->type;
            $account = $request->account;

            switch($type) {
                case 'twitter':
                    $user->twitter = $account;
                    break;
                case 'facebook':
                    $user->facebook = $account;
                    break;
                case 'discord':
                    $user->discord = $account;
                    break;
                default:
                    $user->telegram = $account;
            }

            $user->save();
        } catch(\Exception $e) {
            $user = null;
        }

        return $user;
    }
}
