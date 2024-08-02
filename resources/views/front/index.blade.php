@extends('layouts.app')
@section('content')
    <main class="container my-4">
        <section id="check-status" class="mb-4">
            <h2>Check Ticket Status</h2>
            <form id="status-form" class="mb-3">
                <div class="mb-3">
                    <label for="reference-number" class="form-label">Reference Number:</label>
                    <input type="text" id="reference" name="referenceNumber" class="form-control" required>
                </div>
                <button type="button" id="check-status-button" onclick="getTicket()" class="btn btn-primary">Check Status</button>
            </form>
        </section>

        <section id="ticket-details" style="display: none;">

            <div id="ticketDetails"></div>
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
                    <form id="ticketForm">
                        <div class="mb-3">
                            <label for="customer-name" class="form-label">Customer Name:</label>
                            <input type="text" id="name" name="customerName" class="form-control" required>
                            <span class="validation error-name text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="problem-description" class="form-label">Problem Description:</label>
                            <textarea id="problem" name="problemDescription" class="form-control" required></textarea>
                            <span class="validation error-problem text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                            <span class="validation error-email text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number:</label>
                            <input type="tel" id="mobile" name="phone" class="form-control" required>
                            <span class="validation error-mobile text-danger"></span>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="ticketSubmit()">Submit Ticket</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        function ticketSubmit() {
            let route = '{{ route('front.tickets.store') }}';
            let data;
            let name = $('#ticketForm #name').val();
            let email = $('#ticketForm #email').val();
            let mobile = $('#ticketForm #mobile').val();
            let problem = $('#ticketForm #problem').val();

            data = {
                name: name,
                email: email,
                mobile: mobile,
                problem: problem,
            }

            axios({
                method: 'POST',
                url: route,
                data: data,
                headers: {
                    "Content-Type": "multipart/form-data"
                },
            })
                .then(function(response) {
                    clearForm();

                    let ticketReference = response.data.reference;

                    $('#submitTicketModal').modal('show');
                    $('#submitTicketModal .modal-body').html(`
            <p>Your ticket has been submitted successfully.</p>
            <p><strong>Reference Number:</strong> ${ticketReference}</p>
        `);

                })
                .catch(function(error) {
                    $('.validation').text('');

                    if (error.response && error.response.status === 422) {
                        let errors = error.response.data.errors;
                        $.each(errors, function (field, error) {
                            $(`.error-${field}`).text(error[0]);
                        });
                    }
                });
        }

        function clearForm() {
            $('#ticketForm .validation').text('')
        }

        function getTicket() {

            $('#ticketDetails div').remove()
            let reference = document.getElementById('reference').value.trim();

            if (reference.length === 0) {
                alert('Reference number must contain at least one character.');
                return;
            }

            axios.get(`{{ route('front.tickets.fetch') }}`,
                {
                    params:
                        {
                            reference: reference,
                        }
                }
            ).then(function(response) {
                const tickets = response.data.tickets.data;

                let ticketContainer = document.getElementById('ticketDetails');
                ticketContainer.innerHTML = '';

                if (tickets.length === 0) {
                    ticketContainer.innerHTML = `
                <h2>Ticket Details</h2>
                <p style="color: red;">Incorrect reference number. No ticket found.</p>
            `;
                } else {
                    tickets.forEach(ticket => {
                        if (ticket.status === 'pending') {
                            ticketContainer.innerHTML += `
                        <h2>Ticket Details</h2>
                        <p>Status: <span style="background-color: yellow; color: black;">${ticket.status}</span></p>
                    `;
                        } else {
                            ticketContainer.innerHTML += `
                        <h2>Ticket Details</h2>
                        <p><strong>Problem:</strong> ${ticket.problem}</p>
                        <p><strong>Support Agent Reply:</strong> ${ticket.reply}</p>
                        <p><strong>Status:</strong> ${ticket.status}</p>
                    `;
                        }
                    });
                }

                document.getElementById('ticket-details').style.display = 'block';
            })
                .catch(function (error) {
                    console.error('Error fetching Tickets:', error);
                });
        }
    </script>
@endsection
