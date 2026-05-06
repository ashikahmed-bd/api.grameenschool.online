<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Course Notification</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f7;
      margin: 0;
      padding: 0;
      color: #333;
    }
    .email-container {
      max-width: 600px;
      margin: 40px auto;
      background-color: #ffffff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .email-header {
      background-color: #1d72b8;
      padding: 20px;
      text-align: center;
    }
    .email-header img {
      width: 120px;
      height: auto;
    }
    .email-body {
      padding: 30px 20px;
    }
    .email-body h1 {
      font-size: 24px;
      color: #1d72b8;
    }
    .email-body p {
      font-size: 16px;
      line-height: 1.5;
    }
    .course-info {
      margin: 20px 0;
      padding: 15px;
      background-color: #f0f4f8;
      border-radius: 6px;
    }
    .course-info p {
      margin: 5px 0;
    }
    .btn {
      display: inline-block;
      padding: 12px 24px;
      margin-top: 20px;
      background-color: #1d72b8;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
    }
    .email-footer {
      padding: 20px;
      font-size: 14px;
      text-align: center;
      color: #777;
      background-color: #f4f4f7;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <!-- Header -->
    <div class="email-header">
      <img src="{{ asset('public/logo/logo.png') }}" alt="{{ config('app.name') }}">
    </div>

    <!-- Body -->
    <div class="email-body">
      <h1>🎉 New Course Created!</h1>
      <p>Hello {{ $user->name }},</p>
      <p>A new course has just been added to our platform. Check out the details below:</p>

      <div class="course-info">
        <p><strong>Course Title:</strong> {{ $course->title }}</p>
        <p><strong>Created By:</strong> {{ $course->author->name ?? 'Admin' }}</p>
        <p><strong>Created At:</strong> {{ $course->created_at->format('F j, Y g:i A') }}</p>
      </div>

      <a href="{{ client_url('/course/' . $course->slug) }}" class="btn">View Course</a>

      <p>Stay tuned for more updates!</p>
    </div>

    <!-- Footer -->
    <div class="email-footer">
      &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
  </div>
</body>
</html>
