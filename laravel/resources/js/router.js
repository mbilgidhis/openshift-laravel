import Vue from 'vue';
import VueRouter from 'vue-router'
Vue.use(VueRouter)


// import Dashboard from './components/dashboard.vue';
// import ListAsset from './components/list-asset.vue';
// import Monitoring from './components/monitoring.vue';
// import Mutation from './components/mutation.vue';
// // Form
import FormTaskPlan from './components/form/FormTaskPlan.vue';

const routes = [
    {
        path: '/task/plan/create',
        name: 'task-plan-create',
        component: FormTaskPlan
    },

]
    // {
    //     path: '/list-asset',
    //     name: 'list-asset',
    //     component: ListAsset
    // },
    // {
    //     path: '/monitoring',
    //     name: 'monitoring',
    //     component: Monitoring
    // },
    // {
    //     path: '/mutation',
    //     name: 'mutation',
    //     component: Mutation
    // },
    // {
    //     path: '/mutation/create',
    //     name: 'mutation-create',
    //     component: FormMutation
    // },
    // {
    //     path: '/report',
    //     name: 'report',
    //     component: Report,
    //     children: [
    //         {
    //             path: 'activity',
    //             name: 'report-activity',
    //             component: ReportActivity
    //         },
    //         {
    //             path: 'depreciation',
    //             name: 'report-depreciation',
    //             component: ReportDepreciation
    //         },
    //         {
    //             path: 'monitoring',
    //             name: 'report-monitoring',
    //             component: ReportMonitoring
    //         },
    //         {
    //             path: 'mutation',
    //             name: 'report-mutation',
    //             component: ReportMutation
    //         },
    //     ]
    // },
    // {
    //     path: '/setting',
    //     name: 'setting',
    //     component: Setting,
    //     children: [
    //         {
    //             path: 'category',
    //             name: 'setting-category',
    //             component: SettingCategory
    //         },
    //         {
    //             path: 'depreciation',
    //             name: 'setting-depreciation',
    //             component: SettingDepreciation,
    //         },
    //         {
    //             path: 'depreciation/create',
    //             name: 'setting-depreciation-create',
    //             component: SettingFormDepreciation
    //         },
    //         {
    //             path: 'category/create',
    //             name: 'setting-category-create',
    //             component: SettingFormCategory
    //         },
    //         {
    //             path: 'location',
    //             name: 'setting-location',
    //             component: SettingLocation
    //         },
    //         {
    //             path: 'location/create',
    //             name: 'setting-location-create',
    //             component: SettingFormLocation
    //         },
    //     ]
    // },

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
  routes // short for `routes: routes`
})

export default router;
