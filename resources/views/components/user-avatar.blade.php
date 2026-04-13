@props(['user', 'size' => 'w-12 h-12'])

@if($user->image)
    <img src="{{ Storage::url($user->image) }}" alt="{{ $user->username }}" class="{{ $size }} rounded-full">
@else
    <img src="https://i.pinimg.com/originals/54/72/d1/5472d1b09d3d724228109d381d617326.jpg" alt="diummy image" class="{{ $size }} rounded-full">
@endif