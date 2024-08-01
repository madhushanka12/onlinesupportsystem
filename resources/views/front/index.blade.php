@extends('layouts.app')
@section('content')
    <main class="container my-4">
        <section id="check-status" class="mb-4">
            <h2>Check Ticket Status</h2>
            <form id="status-form" class="mb-3">
                <div class="mb-3">
                    <label for="reference-number" class="form-label">Reference Number:</label>
                    <input type="text" id="reference-number" name="referenceNumber" class="form-control" required>
                </div>
                <button type="button" id="check-status-button" class="btn btn-primary">Check Status</button>
            </form>
        </section>

        <section id="ticket-details" style="display: none;">
            <h2>Ticket Details</h2>
            <p>No details to display yet.</p>
        </section>
    </main>

    <div class="modal fade" id="submitTicketModal" tabindex="-1" aria-labelledby="submitTicketModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submitTicketModalLabel">Submit a Support Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="ticket-form">
                        <div class="mb-3">
                            <label for="customer-name" class="form-label">Customer Name:</label>
                            <input type="text" id="customer-name" name="customerName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="problem-description" class="form-label">Problem Description:</label>
                            <textarea id="problem-description" name="problemDescription" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number:</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Ticket</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


