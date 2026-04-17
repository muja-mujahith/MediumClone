@props(['user'])

<div {{ $attributes }} x-data="{
    following: {{ auth()->check() && $user->isFollowedBy(auth()->user()) ? 'true' : 'false' }},
    followersCount: {{ $user->followers()->count() }},
    follow() {
        this.following = !this.following

        axios.post('/follow/{{ $user->id }}')
            .then(res => {
                console.log(res.data)

                // depending on your backend
                this.followersCount = res.data.followersCount ?? res.data
            })
            .catch(err => {
                console.log(err)
            })
    }
}" class="w-[320px] border-1 px-8">
    {{ $slot }}
</div>