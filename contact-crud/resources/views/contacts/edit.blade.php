<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact</title>
</head>
<body>
    <h1>Edit Contact</h1>
    <a href="{{ route('contacts.index') }}">Back to Contacts</a>

    <form action="{{ route('contacts.update', $contact->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $contact->first_name) }}" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $contact->last_name) }}" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email', $contact->email) }}" required><br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone', $contact->phone) }}" required><br>

        <button type="submit">Update Contact</button>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </ul>
            </div>
        @endif

    </form>
</body>
</html>
