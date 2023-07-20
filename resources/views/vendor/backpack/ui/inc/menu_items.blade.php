{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Benutzers" icon="la la-question" :link="backpack_url('benutzer')" />
<x-backpack::menu-item title="Cats" icon="la la-question" :link="backpack_url('cat')" />
<x-backpack::menu-item title="Places" icon="la la-question" :link="backpack_url('place')" />
<x-backpack::menu-item title="Patients" icon="la la-question" :link="backpack_url('patient')" />
<x-backpack::menu-item title="Spents" icon="la la-question" :link="backpack_url('spent')" />
<x-backpack::menu-item title="Actes" icon="la la-question" :link="backpack_url('acte')" />
<x-backpack::menu-item title="Expenses" icon="la la-question" :link="backpack_url('expenses')" />