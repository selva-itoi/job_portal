@component('mail::message')
# New Job Opportunity: {{ $jobs->title }}

Dear ,

We are thrilled to announce a new job opportunity that might be of interest to you:

Job Title: {{ $jobs->title }}  
Company: {{ $jobs->company }}  
Location: {{ $jobs->location }}

If you are looking for a challenging role in a reputable company, this could be the perfect match for your skills and aspirations.

To apply and learn more about the position, click the "Apply Now" button below:

@component('mail::button', ['url' => $jobs->apply_link])
Apply Now
@endcomponent

Thank you for considering this opportunity. We look forward to receiving your application.

Best Regards,  
[BD'S]
@endcomponent
