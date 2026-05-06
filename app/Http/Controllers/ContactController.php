<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\ContactResource;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contacts = Contact::query()
            ->orderByRaw("FIELD(status, 'pending', 'reviewed', 'resolved')")
            ->paginate($request->limit);
        return ContactResource::collection($contacts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'phone'   => 'required|string|max:20',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
        ]);

        $count = Contact::query()->where('ip_address', $request->ip())
            ->whereDate('created_at', now()->toDateString())
            ->count();

        if ($count >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'You have reached the daily submission limit from your IP address.'
            ], 429);
        }

        Contact::query()->create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for contacting us!'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return ContactResource::make($contact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'reviewed', 'resolved'])],
        ]);

        $contact->status = $request->status;
        $contact->save();

        return response()->json([
            'success' => true,
            'message' => 'Contact status updated successfully.',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact deleted successfully',
        ], Response::HTTP_OK);
    }
}
