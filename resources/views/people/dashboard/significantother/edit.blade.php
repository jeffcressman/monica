@extends('layouts.skeleton')

@section('content')
  <div class="people-show significantother">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
      <div class="{{ Auth::user()->getFluidLayout() }}">
        <div class="row">
          <div class="col-xs-12">
            <ul class="horizontal">
              <li>
                <a href="/dashboard">{{ trans('app.breadcrumb_dashboard') }}</a>
              </li>
              <li>
                <a href="/people">{{ trans('app.breadcrumb_list_contacts') }}</a>
              </li>
              <li>
                {{ $contact->getCompleteName() }}
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Page header -->
    @include('people._header')

    <!-- Page content -->
    <div class="main-content modal">
      <div class="{{ Auth::user()->getFluidLayout() }}">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-sm-offset-3">
            <form method="POST" action="/people/{{ $contact->id }}/significantother/{{ $contact->getCurrentSignificantOther()->id }}/save">
              {{ csrf_field() }}

              @include('partials.errors')

              <h2>{{ trans('people.significant_other_add_title', ['name' => $contact->getFirstName()]) }}</h2>

              {{-- Gender --}}
              <fieldset class="form-group">
                <label class="form-check-inline">
                  @if ($contact->getCurrentSignificantOther()->gender == 'male')
                  <input type="radio" class="form-check-input" name="gender" id="genderMale" value="male" checked>
                  @else
                  <input type="radio" class="form-check-input" name="gender" id="genderMale" value="male">
                  @endif
                  {{ trans('people.significant_other_add_male') }}
                </label>

                <label class="form-check-inline">
                  @if ($contact->getCurrentSignificantOther()->gender == 'female')
                  <input type="radio" class="form-check-input" name="gender" id="genderFemale" value="female" checked>
                  @else
                  <input type="radio" class="form-check-input" name="gender" id="genderFemale" value="female">
                  @endif
                  {{ trans('people.significant_other_add_female') }}
                </label>
              </fieldset>

              {{-- First name --}}
                <div class="form-group">
                  <label for="firstname">{{ trans('people.significant_other_add_firstname') }}</label>
                  <input type="text" class="form-control" name="firstname" value="{{ $contact->getCurrentSignificantOther()->getName() }}" autofocus required>
                </div>

              <fieldset class="form-group dates">

                {{-- Don't know the birthdate --}}
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="birthdateApproximate" value="unknown" {{ ($contact->getCurrentSignificantOther()->is_birthdate_approximate == 'unknown')?'checked':'' }}>

                    <div class="form-inline">
                      {{ trans('people.significant_other_add_unknown') }}
                    </div>
                  </label>
                </div>

                {{-- Approximate birthdate --}}
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="birthdateApproximate" value="approximate" {{ ($contact->getCurrentSignificantOther()->is_birthdate_approximate == 'approximate')?'checked':'' }}>

                    <div class="form-inline">
                      {{ trans('people.significant_other_add_probably') }}

                      <input type="number" class="form-control" name="age"
                              value="{{ (is_null($contact->getCurrentSignificantOther()->getAge())) ? 1 : $contact->getCurrentSignificantOther()->getAge() }}"
                              min="1"
                              max="99">

                      {{ trans('people.significant_other_add_probably_yo') }}
                    </div>
                  </label>
                </div>

                {{-- Exact birthdate --}}
                <div class="form-check">
                  <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="birthdateApproximate" value="exact" {{ ($contact->getCurrentSignificantOther()->is_birthdate_approximate == 'exact')?'checked':'' }}>

                      <div class="form-inline">
                        {{ trans('people.significant_other_add_exact') }}
                        <input type="date" name="specificDate" class="form-control"
                              value="{{ (is_null($contact->getCurrentSignificantOther()->getBirthdate())) ? \Carbon\Carbon::now(Auth::user()->timezone)->format('Y-m-d') : $contact->getCurrentSignificantOther()->getBirthdate()->format('Y-m-d') }}"
                              min="{{ \Carbon\Carbon::now(Auth::user()->timezone)->subYears(120)->format('Y-m-d') }}"
                              max="{{ \Carbon\Carbon::now(Auth::user()->timezone)->format('Y-m-d') }}">
                      </div>
                  </label>
                </div>
              </fieldset>

              <div class="classname">
                <p>{{ trans('people.significant_other_add_help') }}</p>
              </div>

              <div class="form-group actions">
                <button type="submit" class="btn btn-primary">{{ trans('people.significant_other_edit_cta') }}</button>
                <a href="/people/{{ $contact->id }}" class="btn btn-secondary">{{ trans('app.cancel') }}</a>
              </div> <!-- .form-group -->
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection
