@props(['faqs' => []])

@if(count($faqs) > 0)
<section class="faq-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="text-center mb-5">Domande Frequenti</h2>
                <div class="accordion" id="faqAccordion">
                    @foreach($faqs as $index => $faq)
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq{{ $index }}">
                            <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#faqCollapse{{ $index }}" 
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                    aria-controls="faqCollapse{{ $index }}">
                                {{ $faq['question'] }}
                            </button>
                        </h3>
                        <div id="faqCollapse{{ $index }}" 
                             class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                             aria-labelledby="faq{{ $index }}" 
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {{ $faq['answer'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Structured Data -->
<script type="application/ld+json">
{!! json_encode(\App\Http\Controllers\SeoController::getFaqStructuredData($faqs), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endif
