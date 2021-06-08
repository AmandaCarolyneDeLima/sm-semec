 <div class="form-footer">
    <div class="d-flex">
        <a class="btn btn-secondary" href="{{ $back_url }}">{{ $left_link ?? 'Voltar'}}</a>
        <input type="submit" value="{{ $value ?? ''}}" class="btn btn-primary ml-auto" data-disable-with="{{ $value}}" />
    </div>
 </div>
