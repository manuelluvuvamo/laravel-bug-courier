<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Internal Server Error</title>
    <link href="{{ asset('vendor/bug-courier/css/bootstrap.min.css')}}" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            text-align: center;
        }
        .error-container {
            margin-top: 10%;
        }
        .btn-custom {
            border-radius: 50px;
            padding: 10px 30px;
            font-size: 1.2rem;
        }

        .internalerror-500 {
            height: 280px;
            position: relative;
            z-index: -1;
        }

        .internalerror-500 h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 230px;
            margin: 0px;
            font-weight: 900;
            position: absolute;
            left: 50%;
            -webkit-transform: translateX(-50%);
                -ms-transform: translateX(-50%);
                    transform: translateX(-50%);
            background: url("{{ asset('vendor/bug-courier/images/bg2.jpg')}}") no-repeat;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: cover;
            background-position: center;
        }

        @media only screen and (max-width: 767px) {
            .internalerror-500 {
            height: 142px;
            }
            .internalerror-500 h1 {
            font-size: 112px;
            }
        }

    </style>
</head>
<body>
    <div class="error-container">
        <div class="internalerror-500">
				<h1>Oops!</h1>
		</div>
        <h2 class="text-dark fw-bold">500 - Internal Server Error</h2>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <p class="text-muted">Something went wrong on our end. Please try again later.</p>
        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn btn-primary btn-custom">Go to Homepage</a>
            <button class="btn btn-danger btn-custom" data-bs-toggle="modal" data-bs-target="#reportModal">
                Report Issue
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Report an Issue</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('bug-courier.report') }}" method="POST">
                        @csrf
                        <div class="mb-3 text-start">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ session('exception_title') }}" readonly>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label">Observations</label>
                            <textarea class="form-control" name="observations" rows="4" placeholder="Describe the issue..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Submit Report</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/bug-courier/js/bootstrap.bundle.min.js')}}"></script>
</body>
</html>
