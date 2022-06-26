<?php

namespace Adrian\Website\Semiva\Service;

use Adrian\Website\Semiva\Config\Database;
use Adrian\Website\Semiva\Domain\User;
use Adrian\Website\Semiva\Exception\ValidationException;
use Adrian\Website\Semiva\Model\UserLoginRequest;
use Adrian\Website\Semiva\Model\UserLoginResponse;
use Adrian\Website\Semiva\Model\UserPasswordUpdateRequest;
use Adrian\Website\Semiva\Model\UserPasswordUpdateResponse;
use Adrian\Website\Semiva\Model\UserProfileUpdateRequest;
use Adrian\Website\Semiva\Model\UserProfileUpdateResponse;
use Adrian\Website\Semiva\Model\UserRegisterRequest;
use Adrian\Website\Semiva\Model\UserRegisterResponse;
use Adrian\Website\Semiva\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request): UserRegisterResponse
    {
        $this->validateUserRegistrationRequest($request);

        try {
            Database::beginTransaction();
            $user = $this->userRepository->findById($request->id);
            if ($user != null) {
                throw new ValidationException("User Id already exists");
            }

            $user = new User();
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = password_hash($request->password, PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $response = new UserRegisterResponse();
            $response->user = $user;

            Database::commitTransaction();
            return $response;
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    private function validateUserRegistrationRequest(UserRegisterRequest $request)
    {
        if ($request->email == null || $request->username == null || $request->password == null ||
            trim($request->email) == "" || trim($request->username) == "" || trim($request->password) == "") {
            throw new ValidationException("Email, username, Password can not blank");
        }
    }

    public function login(UserLoginRequest $request): UserLoginResponse
    {
        $this->validateUserLoginRequest($request);

        $user = $this->userRepository->findById($request->id);
        if ($user == null) {
            throw new ValidationException("Email or password is wrong");
        }

        if (password_verify($request->password, $user->password)) {
            $response = new UserLoginResponse();
            $response->user = $user;
            return $response;
        } else {
            throw new ValidationException("Email or password is wrong");
        }
    }

    private function validateUserLoginRequest(UserLoginRequest $request)
    {
        if ($request->email == null || $request->password == null ||
            trim($request->email) == "" || trim($request->password) == "") {
            throw new ValidationException("Id, Password can not blank");
        }
    }

    public function updateProfile(UserProfileUpdateRequest $request): UserProfileUpdateResponse
    {
        $this->validateUserProfileUpdateRequest($request);

        try {
            Database::beginTransaction();

            $user = $this->userRepository->findById($request->id);
            if ($user == null) {
                throw new ValidationException("User is not found");
            }

            $user->username = $request->username;
            $this->userRepository->update($user);

            Database::commitTransaction();

            $response = new UserProfileUpdateResponse();
            $response->user = $user;
            return $response;
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    private function validateUserProfileUpdateRequest(UserProfileUpdateRequest $request)
    {
        if ($request->id == null || $request->username == null ||
            trim($request->id) == "" || trim($request->username) == "") {
            throw new ValidationException("Id, username can not blank");
        }
    }

    public function updatePassword(UserPasswordUpdateRequest $request): UserPasswordUpdateResponse
    {
        $this->validateUserPasswordUpdateRequest($request);

        try {
            Database::beginTransaction();

            $user = $this->userRepository->findById($request->id);
            if ($user == null) {
                throw new ValidationException("User is not found");
            }

            if (!password_verify($request->oldPassword, $user->password)) {
                throw new ValidationException("Old password is wrong");
            }

            $user->password = password_hash($request->newPassword, PASSWORD_BCRYPT);
            $this->userRepository->update($user);

            Database::commitTransaction();

            $response = new UserPasswordUpdateResponse();
            $response->user = $user;
            return $response;
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    private function validateUserPasswordUpdateRequest(UserPasswordUpdateRequest $request)
    {
        if ($request->id == null || $request->oldPassword == null || $request->newPassword == null ||
            trim($request->id) == "" || trim($request->oldPassword) == "" || trim($request->newPassword) == "") {
            throw new ValidationException("Id, Old Password, New Password can not blank");
        }
    }
}