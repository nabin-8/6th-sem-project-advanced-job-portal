<div class="accordion mb-4" id="faqAccordion">
    @foreach($faqs as $faq)
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse{{ $faq->id }}">
                    {{ $faq->question }}
                </button>
            </h2>
            <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    {!! $faq->answer !!}
                </div>
            </div>
        </div>
    @endforeach
</div>
