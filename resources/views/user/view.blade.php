<x-app-layout>
    
    <table class="table-auto" width="100%">
        <thead>
            <tr>
                <th class="border text-left p-8 p-4">User</th>
                <th class="border text-left p-8 p-4">Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="border text-left p-8 p-4">{{ $user->name }}</td>
                    <td class="border text-left p-8 p-4">{{ $user->email }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="text-left">{{ $users->links() }}</td>
            </tr>
        </tbody>
    </table>
</x-app-layout>