@extends('layouts.empty')

@section('content')
    <div class="flex flex-col w-full">
        <iframe id="pdfViewer" class="w-full h-[90vh]" src="{{ asset('document.pdf') }}" frameborder="0"></iframe>
        <button id="savePdf">Save PDF</button>
    </div>
@endsection

@section('foot')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <script>
        const { PDFDocument } = PDFLib;
        let pdfDoc; // Store the PDF document globally

        document.getElementById('savePdf').addEventListener('click', async () => {
    
            const pdfBytes = await pdfDoc.save();

            // Create a FormData object to send the PDF to the server
            const formData = new FormData();
            formData.append('pdf', new Blob([pdfBytes], { type: 'application/pdf' }), 'filled_document.pdf');

            // Send the PDF to the server to save it
            fetch("{{ route('pdf.save') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('PDF saved successfully!');
                } else {
                    alert('Failed to save PDF.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving the PDF.');
            });
        });
    </script>
@endsection
