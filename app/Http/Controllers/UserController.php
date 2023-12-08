<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function getUserInfo($userId): JsonResponse
    {
        try {
            $user = UserInfo::where('user_id',$userId)->first();
            return response()->json(['userInfo' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, int $userId): JsonResponse
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'avatar' => 'url',
                'bio' => 'string',
                'phone' => 'string',
            ]);

            // Check if the user exists
            $userInfo = UserInfo::where('user_id', $userId)->first();

            if (!$userInfo) {
                throw new \Exception('User Not Found!');
            }

            // Update the user info
            $userInfo->update($validatedData);

            // Refresh the model to get the updated data
            $userInfo->refresh();

            return response()->json([
                'message' => 'User Info updated successfully',
                'userInfo' => $userInfo
            ]);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($userId): JsonResponse
    {
        try {
            $userInfo = UserInfo::where('user_id',$userId)->first();
            $userInfo->delete();
            return response()->json(['message' => 'User Info deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
